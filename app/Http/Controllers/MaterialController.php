<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Unit;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::query();

        // 🔍 Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_material', 'like', "%{$search}%")
                    ->orWhere('uraian_material', 'like', "%{$search}%")
                    ->orWhere('total_saldo', 'like', "%{$search}%")
                    ->orWhere('satuan', 'like', "%{$search}%");
            });
        }

        // 🔄 Sorting
        $sortBy = in_array($request->sort, ['created_at', 'kode_material', 'uraian_material', 'total_saldo', 'satuan'])
            ? $request->sort
            : 'created_at';
        $order = $request->order === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $order);

        // 📄 Pagination
        $materials = $query->paginate(10)->withQueryString();

        $units = Unit::all();

        $kodeUnitSession = session('kodeunit'); // pastikan session('kodeunit') sudah di-set saat login
        $unitAdministrasi = Material::where('plant', $kodeUnitSession)
            ->orderBy('kode_material', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.material', [
            'title' => 'Material',
            'materials' => $materials,
            'unitAdministrasi' => $unitAdministrasi,
            'units'     => $units,
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'plant'      => 'required|string|max:50',
            'kode_material'   => 'required|max:50|unique:materials,kode_material',
            'uraian_material' => 'required|string|max:255',
            'total_saldo'     => 'nullable|string|max:50',
        ]);

        Material::create([
            'plant'      => $request->plant,
            'kode_material'   => $request->kode_material,
            'uraian_material' => $request->uraian_material,
            'total_saldo'     => $request->total_saldo ?? 0,
        ]);


        // Redirect balik dengan pesan sukses
        return redirect()->route('materials')->with('success', 'Material berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        // Validasi data
        $request->validate([
            'plant'      => 'required|string|max:50',
            'kode_material'   => 'required|max:50|unique:materials,kode_material,' . $material->id,
            'uraian_material' => 'required|string|max:255',
            'total_saldo'     => 'nullable|string|max:50',
        ]);

        $material->update([
            'plant'      => $request->plant,
            'kode_material'   => $request->kode_material,
            'uraian_material' => $request->uraian_material,
            'total_saldo'     => $request->total_saldo ?? $material->total_saldo,
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
