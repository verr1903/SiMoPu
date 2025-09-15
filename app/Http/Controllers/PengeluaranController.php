<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\Material;
use App\Models\Notification;
use App\Models\RealisasiPengeluaran;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar
        $query = Pengeluaran::with('material');

        // 🔍 Search
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('material', function ($q) use ($request) {
                $q->where('kode_material', 'like', '%' . $request->search . '%');
            })
                ->orWhere('tanggal_keluar', 'like', '%' . $request->search . '%')
                ->orWhere('saldo_keluar', 'like', '%' . $request->search . '%')
                ->orWhere('sumber', 'like', '%' . $request->search . '%');
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
        $PengeluaransDiterima = Pengeluaran::with('material')
            ->where('status', 'diterima')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'tabel2')->withQueryString();

        $materials = Material::orderBy('created_at', 'desc')->get();

        return view('admin.pengeluaran', [
            'title'                => 'Pengeluaran',
            'Pengeluarans'         => $Pengeluarans,
            'PengeluaransDiterima' => $PengeluaransDiterima,
            'materials'            => $materials,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'material_id'    => 'required|exists:materials,id',
            'tanggal_keluar' => 'required|date',
            'saldo_keluar'   => 'required|integer|min:1',
            'sumber'         => 'required|string|max:255',
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

        if ($request->status === 'ditolak') {
            $pengeluaran->update([
                'status' => 'ditolak',
            ]);

            $message = <<<MSG
                        Pengajuan Pengeluaran Ditolak
                        Kode Material : {$pengeluaran->material->kode_material}, 
                        Tanggal Keluar: {$pengeluaran->tanggal_keluar}, 
                        Saldo Keluar  : {$pengeluaran->saldo_keluar}, 
                        Blok          : {$pengeluaran->sumber}
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
                'qty_pengeluaran' => $request->input('pengeluaran_detail'), // array disimpan
            ]);

            $message = <<<MSG
                        Pengajuan Pengeluaran Diterima
                        Kode Material : {$pengeluaran->material->kode_material},
                        Tanggal Keluar: {$pengeluaran->tanggal_keluar},
                        Saldo Keluar  : {$pengeluaran->saldo_keluar},
                        Blok        : {$pengeluaran->sumber}
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
                        $q->where('sumber', 'like', "%{$search}%")
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

        if (in_array($sort, ['created_at', 'tanggal_keluar', 'sumber'])) {
            $query->orderBy($sort, $order);
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
}
