<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KelolaUserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index(Request $request)
    {
        // Ambil query dari request
        $search = $request->input('search');
        $sort = $request->input('sort', 'created_at'); // default: created_at
        $order = $request->input('order', 'asc');      // default: asc

        $query = User::with(['User.unit', 'user.unit']);
        $units = Unit::all(); // ambil semua unit
        // Query user
        $materials = User::query()
            ->when($search, function ($query, $search) {
                $query->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('level_user', 'like', "%{$search}%");
            })
            ->orderBy($sort, $order)
            ->paginate(10)
            ->appends($request->only(['search', 'sort', 'order'])); // supaya pagination tetap bawa parameter

        return view('admin.kelolaUser', [
            'title' => 'Kelola User',
            'materials' => $materials,
            'units' => $units,
        ]);
    }


    /**
     * Menampilkan form tambah user
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'username'   => 'required|string|max:255',
            'sap'        => 'required|string|max:50',
            'level_user' => 'required|string|max:255',
            'kodeunit'   => 'required|string|max:50',
        ]);

        // Cari user berdasarkan id
        $user = User::findOrFail($id);

        // Update seluruh field
        $user->update([
            'username'   => $request->username,
            'sap'        => $request->sap,
            'level_user' => $request->level_user,
            'kodeunit'   => $request->kodeunit,
        ]);

        return redirect()->route('users')->with('success', 'Data User berhasil diperbarui.');
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'sap' => 'required|string|max:50|unique:users,sap',
            'level_user' => 'required|string|max:255',
            'kodeunit' => 'required|string|max:50',
        ]);

        User::create([
            'username' => $request->username,
            'sap' => $request->sap,
            'level_user' => $request->level_user,
            'kodeunit' => $request->kodeunit,
            'password' => Hash::make('12345678'), // default password
        ]);

        return redirect()->route('users')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users')->with('success', 'User berhasil dihapus!');
    }
}
