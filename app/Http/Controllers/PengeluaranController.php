<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengeluaran;
use App\Models\Material;
use App\Models\Notification;
use App\Models\RealisasiPengeluaran;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar
        $query = Pengeluaran::with(['material', 'user']);

        // 🔍 Search
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('material', function ($q) use ($request) {
                $q->where('kode_material', 'like', '%' . $request->search . '%');
            })
                ->orWhere('tanggal_keluar', 'like', '%' . $request->search . '%')
                ->orWhere('saldo_keluar', 'like', '%' . $request->search . '%')
                ->orWhere('sumber', 'like', '%' . $request->search . '%');
        }
        $user = Auth::user();

        $blok = [
            'AFD01' => ['9G', '11G', '13G', '15G', '17G', '19G', '21G', '9H', '11H', '13H', '15H', '17H', '19H', '21H', '9I', '11I', '13I', '15I', '17I', '19I', '21I', '9J', '11J', '13J', '15J', '17J', '19J', '21J'],
            'AFD02' => ['9L', '11L', '13L', '15L', '9M', '10O', '12O', '14O', '16O', '18O', '20O', '22O', '24O', '6P', '8P', '10P', '12P', '14P', '16P', '18P', '20P', '22P', '24P', '26P', '28P'],
            'AFD03' => ['14L', '14M', '16M', '18M', '20M', '22M', '12N', '12N1', '14N', '16N', '18N', '20N', '22N', '24N', '26N', '28N', '30N', '24O1', '26O', '28O', '30O', '36O', '26P1', '28P1', '30P', '36P', '38P', '40P'],
            'AFD04' => ['14I', '14I1', '16I', '16I1', '18I', '18J', '20J', '22J', '24J', '12K', '14K', '16K', '18K', '20K', '22K', '24K', '26K', '16L', '18L', '20L', '22L', '24L', '26L', '28L', '16M1', '18M1', '20M1', '22M1', '24M', '26M', '28M', '30M', '26N1', '28N1', '30N1', '1BT'],
        ];

        $blokUser = [];

        if (Str::contains($user->level_user, 'afdeling')) {
            // Ambil bagian '04' lalu tambahkan prefix 'AFD'
            preg_match('/\d+$/', $user->level_user, $matches); // ambil angka di akhir
            $afd = 'AFD' . ($matches[0] ?? '');
            $blokUser = $blok[$afd] ?? [];
        } else {
            $blokUser = array_merge(...array_values($blok));
        }


        // 🔄 Urutkan: status "menunggu" paling atas, lalu by created_at desc
        $query->orderByRaw("
            CASE 
                WHEN status = 'menunggu' THEN 0
                WHEN status = 'diterima' THEN 1
                WHEN status = 'ditolak' THEN 2
                ELSE 3
            END
        ");

        $query->orderByRaw("
            CASE 
                WHEN status = 'menunggu' THEN UNIX_TIMESTAMP(created_at)
                WHEN status = 'diterima' THEN -UNIX_TIMESTAMP(updated_at)
                WHEN status = 'ditolak' THEN UNIX_TIMESTAMP(created_at)
            END
        ");


        // 🔄 Panggil scope yang kita buat
        $Pengeluarans = $query->urutkanStatus()
            ->paginate(10, ['*'], 'tabel1')
            ->withQueryString();

        // 📄 Pagination tabel 2 (hanya diterima)
        $PengeluaransDiterima = Pengeluaran::with(['material', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'tabel2')
            ->withQueryString();

        $materials = Material::orderBy('created_at', 'desc')->get();

        return view('admin.pengeluaran', [
            'title'                => 'Pengeluaran',
            'Pengeluarans'         => $Pengeluarans,
            'PengeluaransDiterima' => $PengeluaransDiterima,
            'materials'            => $materials,
            'blokUser'             => $blokUser,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'material_id'    => 'required|exists:materials,id',
            'tanggal_keluar' => 'required|date',
            'saldo_keluar'   => 'required|integer|min:1',
            'au58'           => 'required|string|max:255',
            'sumber'   => ['required', 'array', 'min:1'],
            'sumber.*' => ['string', 'regex:/^[0-9]+[A-Z]$/'],
            'status'         => 'nullable|string|max:50',
        ]);

        // Ambil user dari session
        $user = \App\Models\User::findOrFail($request->session()->get('id'));
        $material = Material::findOrFail($request->material_id);

        // Simpan pengeluaran
        $pengeluaran = Pengeluaran::create([
            'user_id'        => $request->session()->get('id'), // ambil dari session
            'material_id'    => $request->material_id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'au58'           => $request->au58,
            'saldo_keluar'   => $request->saldo_keluar,
            'saldo_sisa'     => $request->saldo_keluar,
            'sumber'         => $request->sumber,
            'status'         => 'menunggu', // default menunggu
        ]);

        // Kirim notifikasi ke admin dan super admin
        $admins = \App\Models\User::whereIn('level_user', ['administrasi', 'administrator'])->get();

        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'message' => "Pengajuan pengeluaran kode {$material->kode_material} oleh {$user->username} dari {$user->level_user} menunggu persetujuan.",
                'status'  => 'unread',
            ]);
        }

        return redirect()->route('pengeluaran')
            ->with('success', 'Pengeluaran berhasil ditambahkan, menunggu persetujuan Admin!');
    }

    public function updateStatus(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $material = Material::findOrFail($pengeluaran->material_id);

        // Cegah update kalau status sudah berubah
        if ($pengeluaran->status !== 'menunggu') {
            return back()->with('error', 'Status sudah tidak bisa diubah!');
        }

        $penerimaId = $request->input('penerima', Auth::id());

        if ($request->status === 'ditolak') {
            $pengeluaran->update([
                'status' => 'ditolak',
                'penerima' => $penerimaId,
            ]);

            $blokList = implode(', ', (array) $pengeluaran->sumber);


            $message = <<<MSG
                        Pengajuan Pengeluaran Ditolak
                        Kode Material : {$pengeluaran->material->kode_material}, 
                        Tanggal Keluar: {$pengeluaran->tanggal_keluar}, 
                        Saldo Keluar  : {$pengeluaran->saldo_keluar}, 
                        Blok          : {$blokList}
                        MSG;

            Notification::create([
                'user_id' => $pengeluaran->user_id,
                'message' => $message,
            ]);

            return back()->with('error', 'Pengeluaran berhasil ditolak.');
        }

        if ($request->status === 'diterima') {
            if ($material->total_saldo < $pengeluaran->saldo_keluar) {
                return back()->with('error', 'Saldo material tidak mencukupi!');
            }

            $material->decrement('total_saldo', $pengeluaran->saldo_keluar);

            $pengeluaran->update([
                'status' => 'diterima',
                'penerima' => $penerimaId,

            ]);

            $blokList = implode(', ', (array) $pengeluaran->sumber);


            $message = <<<MSG
                        Pengajuan Pengeluaran Diterima
                        Kode Material : {$pengeluaran->material->kode_material},
                        Tanggal Keluar: {$pengeluaran->tanggal_keluar},
                        Saldo Keluar  : {$pengeluaran->saldo_keluar},
                        Blok        : {$blokList}
                        MSG;

            Notification::create([
                'user_id' => $pengeluaran->user_id,
                'message' => $message,
            ]);

            return back()->with('success', 'Pengeluaran berhasil diterima.');
        }

        return back()->with('error', 'Status tidak valid.');
    }

    // realisasi pengeluaran
    public function indexRealisasi(Request $request)
    {
        // Query dasar
        $query = RealisasiPengeluaran::with(['pengeluaran.material', 'pengeluaran.user']);

        // ✅ Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                // Cari di material
                $query->whereHas('pengeluaran.material', function ($q) use ($search) {
                    $q->where('kode_material', 'like', "%{$search}%");
                })
                    // Cari di user
                    ->orWhereHas('pengeluaran.user', function ($q) use ($search) {
                        $q->where('username', 'like', "%{$search}%")
                            ->orWhere('level_user', 'like', "%{$search}%");
                    })
                    // Cari di pengeluaran
                    ->orWhereHas('pengeluaran', function ($q) use ($search) {
                        $q->whereJsonContains('sumber', $search) // ✅ array-safe
                            ->orWhereDate('tanggal_keluar', 'like', "%{$search}%");
                    })
                    // Cari di tabel realisasi_pengeluaran sendiri
                    ->orWhere('cicilan_pengeluaran', 'like', "%{$search}%")
                    ->orWhereDate('created_at', 'like', "%{$search}%");
            });
        }


        // ✅ Sorting
        $sort  = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');

        if (in_array($sort, ['created_at', 'tanggal_keluar'])) {
            $query->orderBy($sort, $order);
        } elseif ($sort === 'sumber') {
            $query->join('pengeluarans', 'realisasi_pengeluarans.pengeluaran_id', '=', 'pengeluarans.id')
                ->orderBy('pengeluarans.sumber', $order)
                ->select('realisasi_pengeluarans.*');
        } elseif ($sort === 'kode_material') {
            $query->join('pengeluarans', 'realisasi_pengeluarans.pengeluaran_id', '=', 'pengeluarans.id')
                ->join('materials', 'pengeluarans.material_id', '=', 'materials.id')
                ->orderBy('materials.kode_material', $order)
                ->select('realisasi_pengeluarans.*');
        } elseif ($sort === 'qty') {
            $query->orderBy('cicilan_pengeluaran', $order);
        }


        // ✅ Ambil data
        $realisasiPengeluarans = $query->paginate(10)->appends($request->all());

        // Pilihan pengeluaran (untuk tambah realisasi)
        $pengeluarans = Pengeluaran::with(['material', 'user'])
            ->where('status', 'diterima')
            ->where('saldo_sisa', '>', 0)
            ->get();

        return view('admin.realisasiPengeluaran', [
            'title'                 => 'Realisasi Pengeluaran',
            'realisasiPengeluarans' => $realisasiPengeluarans,
            'pengeluarans'          => $pengeluarans,
        ]);
    }

    public function storeRealisasi(Request $request)
    {
        // Validasi input
        $request->validate([
            'pengeluaran_id'      => 'required|exists:pengeluarans,id',
            'cicilan_pengeluaran' => 'required|integer|min:1',
        ]);

        // Ambil pengeluaran terkait
        $pengeluaran = Pengeluaran::findOrFail($request->pengeluaran_id);

        // Cek jika cicilan melebihi saldo_sisa
        if ($request->cicilan_pengeluaran > $pengeluaran->saldo_sisa) {
            return back()->with('error', 'Cicilan melebihi saldo sisa!');
        }

        // Simpan ke tabel realisasi_pengeluarans
        RealisasiPengeluaran::create([
            'pengeluaran_id'      => $request->pengeluaran_id,
            'cicilan_pengeluaran' => $request->cicilan_pengeluaran,
        ]);

        // Kurangi saldo_sisa pada tabel pengeluarans
        $pengeluaran->decrement('saldo_sisa', $request->cicilan_pengeluaran);

        return redirect()->route('realisasiPengeluaran')
            ->with('success', 'Realisasi pengeluaran berhasil ditambahkan!');
    }

    public function printRealisasi($id)
    {
        $realisasi = RealisasiPengeluaran::with(['pengeluaran.material', 'pengeluaran.user'])->findOrFail($id);
        $materials = Material::all();
        $users     = User::all();
        // Ubah tanggal ke format Indonesia
        $tanggalKeluar = Carbon::parse($realisasi->pengeluaran->tanggal_keluar)
            ->translatedFormat('d M Y');

        // Siapkan data untuk QR Code
        // $qrData = "Id: " . $realisasi->id . "\n" .
        //     "Kode Material: " . $realisasi->pengeluaran->material->kode_material . "\n" .
        //     "Uraian Material: " . $realisasi->pengeluaran->material->uraian_material . "\n" .
        //     "Afdeling: " . $realisasi->pengeluaran->user->level_user . "\n" .
        //     "Blok: " . $realisasi->pengeluaran->sumber . "\n" .
        //     "Pengeluaran: " . $realisasi->cicilan_pengeluaran . "/Kg\n" .
        //     "Tanggal Keluar: " . $tanggalKeluar;
        $qrData = route('realisasi.scan', ['id' => $realisasi->id]);

        $fileName = 'qrcode_realisasi_' . $realisasi->id . '.png';
        $path = storage_path('app/public/qrcodes/' . $fileName);

        if (!file_exists(storage_path('app/public/qrcodes'))) {
            mkdir(storage_path('app/public/qrcodes'), 0755, true);
        }

        // Generate QR Code sebagai file PNG
        QrCode::format('png')
            ->size(300) // perbesar ukuran biar jelas
            ->errorCorrection('H')
            ->merge(storage_path('app/public/logo/logoqr.png'), 0.4, true)
            ->generate($qrData, $path);

        return view('admin.printRealisasi', [
            'title'     => 'Detail Realisasi',
            'realisasi' => $realisasi,
            'materials' => $materials,
            'users'     => $users,
            'fileName'  => $fileName,
        ]);
    }

    public function scanUpdate($id)
    {
        $realisasi = RealisasiPengeluaran::findOrFail($id);

        $status = 'error';
        $message = '';

        if (is_null($realisasi->scan_keluar)) {
            $realisasi->update(['scan_keluar' => now()]);
            $status = 'success';
            $message = 'Scan keluar berhasil dicatat pada ' . now()->translatedFormat('d F Y H:i:s');
        } elseif (is_null($realisasi->scan_akhir)) {
            $scanKeluar = \Carbon\Carbon::parse($realisasi->scan_keluar);

            if ($scanKeluar->diffInMinutes(now()) >= 1) {
                $realisasi->update(['scan_akhir' => now()]);
                $status = 'success';
                $message = 'Scan akhir berhasil dicatat pada ' . now()->translatedFormat('d F Y H:i:s');
            } else {
                $message = 'Scan akhir hanya bisa dilakukan minimal 1 menit setelah scan keluar';
            }
        } else {
            $message = 'QR ini sudah discan 2 kali (scan keluar & scan akhir sudah tercatat)';
        }

        return view('admin.scanResult', compact('status', 'message'));
    }

    // Edit & Update Realisasi
    public function updateRealisasi(Request $request, $id)
    {
        $realisasi = RealisasiPengeluaran::findOrFail($id);
        $pengeluaran = Pengeluaran::findOrFail($realisasi->pengeluaran->id);
        $request->validate([
            'cicilan_pengeluaran' => 'required|integer|min:1',
        ]);

        // Hitung selisih antara cicilan baru dan lama
        $selisih = $request->cicilan_pengeluaran - $realisasi->cicilan_pengeluaran;

        // Cek apakah cicilan baru lebih besar dari saldo sisa
        if ($selisih > $pengeluaran->saldo_sisa) {
            return back()->with('error', 'Cicilan melebihi saldo sisa!');
        }

        // Update saldo_sisa di tabel pengeluaran
        $pengeluaran->decrement('saldo_sisa', $selisih);

        // Update cicilan_pengeluaran di tabel realisasi
        $realisasi->update([
            'cicilan_pengeluaran' => $request->cicilan_pengeluaran,
        ]);

        return redirect()->route('realisasiPengeluaran')->with('success', 'Realisasi berhasil diupdate!');
    }

    // Hapus Realisasi
    public function destroyRealisasi($id)
    {
        $realisasi = RealisasiPengeluaran::findOrFail($id);
        $pengeluaran = Pengeluaran::findOrFail($realisasi->pengeluaran->id);

        // Kembalikan saldo_sisa
        $pengeluaran->increment('saldo_sisa', $realisasi->cicilan_pengeluaran);

        $realisasi->delete();

        return redirect()->route('realisasiPengeluaran')->with('success', 'Realisasi berhasil dihapus!');
    }
}
