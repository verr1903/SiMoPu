<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\Material;
use Illuminate\Http\Request;

class PenerimaanController extends Controller
{
    public function index(Request $request)
    {
        $kodeUnit = session('kodeunit');

        $query = Penerimaan::with('material');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('material', function ($q2) use ($search) {
                    $q2->where('kode_material', 'like', "%{$search}%")
                        ->orWhere('uraian_material', 'like', "%{$search}%");
                })
                    ->orWhere('tanggal_terima', 'like', "%{$search}%")
                    ->orWhere('saldo_masuk', 'like', "%{$search}%")
                    ->orWhere('sumber', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kodeunit
        if ($kodeUnit !== '3R00') {
            $query->whereHas('material', fn($q) => $q->where('plant', $kodeUnit));
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $order  = $request->get('order', 'desc');
        if (in_array($sortBy, ['kode_material', 'uraian_material'])) {
            $query->orderByRaw("(select {$sortBy} from materials where materials.id = penerimaans.material_id) {$order}");
        } else {
            $query->orderBy("penerimaans.{$sortBy}", $order);
        }

        $penerimaan = $query->paginate(10)->withQueryString();

        $materialsQuery = Material::orderBy('created_at', 'desc');
        if ($kodeUnit !== '3R00') $materialsQuery->where('plant', $kodeUnit);
        $materials = $materialsQuery->get();

        return view('admin.penerimaan', [
            'title' => 'Penerimaan',
            'penerimaan' => $penerimaan,
            'materials' => $materials,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_id'    => 'required|exists:materials,id',
            'tanggal_terima' => 'required|date',
            'saldo_masuk'    => 'required|integer|min:1',
            'sumber'         => 'required|string|max:255',
        ]);

        $penerimaan = Penerimaan::create([
            'material_id'    => $request->material_id,
            'tanggal_terima' => $request->tanggal_terima,
            'saldo_masuk'    => $request->saldo_masuk,
            'sumber'         => $request->sumber,
        ]);

        $material = Material::findOrFail($request->material_id);
        $material->increment('total_saldo', $request->saldo_masuk);

        return redirect()->route('penerimaan')->with('success', 'Penerimaan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $penerimaan = Penerimaan::findOrFail($id);

        $request->validate([
            'material_id'    => 'required|exists:materials,id',
            'tanggal_terima' => 'required|date',
            'saldo_masuk'    => 'required|integer|min:1',
            'sumber'         => 'required|string|max:255',
        ]);

        // Hitung selisih saldo lama
        $material = Material::findOrFail($request->material_id);
        $saldoLama = $penerimaan->saldo_masuk;
        $material->decrement('total_saldo', $saldoLama);
        $material->increment('total_saldo', $request->saldo_masuk);

        $penerimaan->update([
            'material_id'    => $request->material_id,
            'tanggal_terima' => $request->tanggal_terima,
            'saldo_masuk'    => $request->saldo_masuk,
            'sumber'         => $request->sumber,
        ]);

        return redirect()->route('penerimaan')->with('success', 'Penerimaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $penerimaan = Penerimaan::findOrFail($id);

        // Kurangi total saldo material
        $penerimaan->material->decrement('total_saldo', $penerimaan->saldo_masuk);

        $penerimaan->delete();

        return redirect()->route('penerimaan')->with('success', 'Penerimaan berhasil dihapus!');
    }
}
