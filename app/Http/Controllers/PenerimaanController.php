<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\Material;
use Illuminate\Http\Request;

class PenerimaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penerimaan::with('material');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('material', function ($q) use ($search) {
                $q->where('kode_material', 'like', "%{$search}%")
                  ->orWhere('uraian_material', 'like', "%{$search}%");
            })
            ->orWhere('tanggal_terima', 'like', "%{$search}%")
            ->orWhere('saldo_masuk', 'like', "%{$search}%")
            ->orWhere('sumber', 'like', "%{$search}%");
        }

        // Sorting: default penerimaans.created_at
        $sortBy = $request->get('sort', 'created_at');
        $order  = $request->get('order', 'desc');

        // Jika sorting berdasarkan kolom pada tabel materials, gunakan subquery orderBy
        if (in_array($sortBy, ['kode_material', 'uraian_material'])) {
            $query->orderByRaw("(select {$sortBy} from materials where materials.id = penerimaans.material_id) {$order}");
        } else {
            // aman-kan nama kolom ke tabel penerimaans
            $query->orderBy("penerimaans.{$sortBy}", $order);
        }

        $penerimaan = $query->paginate(10)->withQueryString();

        // KIRIM materials untuk dropdown pada modal
        $materials = Material::orderBy('created_at', 'desc')->get();

        return view('admin.penerimaan', [
            'title' => 'Penerimaan',
            'penerimaan' => $penerimaan,
            'materials' => $materials,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'material_id'    => 'required|exists:materials,id',
            'tanggal_terima' => 'required|date',
            'saldo_masuk'    => 'required|integer|min:1',
            'sumber'         => 'required|string|max:255',
        ]);

        // Simpan penerimaan
        $penerimaan = Penerimaan::create([
            'material_id'    => $request->material_id,
            'tanggal_terima' => $request->tanggal_terima,
            'saldo_masuk'    => $request->saldo_masuk,
            'sumber'         => $request->sumber,
        ]);

        // Update total_saldo material
        $material = Material::findOrFail($request->material_id);
        $material->increment('total_saldo', $request->saldo_masuk);

        return redirect()->route('penerimaan')
            ->with('success', 'Penerimaan berhasil ditambahkan!');
    }
}
