<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\Material;

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
        $query->orderByRaw("CASE WHEN status = 'menunggu' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc');

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
            'title'              => 'Pengeluaran',
            'Pengeluarans'       => $Pengeluarans,
            'PengeluaransDiterima' => $PengeluaransDiterima,
            'materials'          => $materials,
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

        $material = Material::findOrFail($request->material_id);

        // ❌ Jangan kurangi saldo dulu, cukup simpan pengeluaran
        $pengeluaran = Pengeluaran::create([
            'material_id'    => $request->material_id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'saldo_keluar'   => $request->saldo_keluar,
            'sumber'         => $request->sumber,
            'status'         => 'menunggu', // default menunggu
        ]);

        return redirect()->route('pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan, Menunggu persetujuan Admin!');
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
        // ✅ Hanya ubah status jadi "ditolak", tidak hapus data
        $pengeluaran->update([
            'status' => 'ditolak',
        ]);

        return back()->with('error', 'Pengeluaran berhasil ditolak.');
    }

    if ($request->status === 'diterima') {
        // ✅ Kurangi saldo baru ketika diterima
        if ($material->total_saldo < $pengeluaran->saldo_keluar) {
            return back()->with('error', 'Saldo material tidak mencukupi!');
        }

        $material->decrement('total_saldo', $pengeluaran->saldo_keluar);

        $pengeluaran->update([
            'status' => 'diterima',
        ]);

        return back()->with('success', 'Pengeluaran berhasil diterima.');
    }

    return back()->with('error', 'Status tidak valid.');
}
}
