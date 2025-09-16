<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            'materials' => $materials
        ]);
    }


    /**
     * Menampilkan form tambah user
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'level_user' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'level_user' => $request->level_user,
        ]);

        return redirect()->route('users')->with('success', 'Jabatan User berhasil diperbarui.');
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
