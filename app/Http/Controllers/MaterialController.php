<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::query();

        // 🔍 Search
        if ($request->has('search') && $request->search != '') {
            $query->where('kode_material', 'like', '%' . $request->search . '%')
                ->orWhere('uraian_material', 'like', '%' . $request->search . '%')
                ->orWhere('total_saldo', 'like', '%' . $request->search . '%')
                ->orWhere('satuan', 'like', '%' . $request->search . '%');
        }

        // 🔄 Sorting
        $sortBy = $request->get('sort', 'created_at'); // default sort by created_at
        $order  = $request->get('order', 'desc');      // default order desc

        $query->orderBy($sortBy, $order);

        // 📄 Pagination
        $materials = $query->paginate(10)->withQueryString();

        return view('admin.material', [
            'title' => 'Material',
            'materials' => $materials,
        ]);
    }



    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'kode_material'   => 'required|max:50|unique:materials,kode_material',
            'uraian_material' => 'required|string|max:255',
            'satuan'          => 'required|string|max:50',
            'total_saldo'     => 'required|string|max:50',
        ]);

        // Simpan data ke DB
        Material::create([
            'kode_material'   => $request->kode_material,
            'uraian_material' => $request->uraian_material,
            'satuan'          => $request->satuan,
            'total_saldo'     => $request->total_saldo,
        ]);

        // Redirect balik dengan pesan sukses
        return redirect()->route('materials')->with('success', 'Material berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        // Validasi data
        $request->validate([
            'kode_material'   => 'required|max:50|unique:materials,kode_material,' . $material->id,
            'uraian_material' => 'required|string|max:255',
            'satuan'          => 'required|string|max:50',
            'total_saldo'     => 'required|string|max:50',
        ]);

        // Update data
        $material->update([
            'kode_material'   => $request->kode_material,
            'uraian_material' => $request->uraian_material,
            'satuan'          => $request->satuan,
            'total_saldo'     => $request->total_saldo,
        ]);

        return redirect()->route('materials')->with('success', 'Material berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('materials')->with('success', 'Material berhasil dihapus!');
    }
}
