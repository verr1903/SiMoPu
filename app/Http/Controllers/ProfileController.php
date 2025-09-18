<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $units = Unit::all();
        return view('admin.edit', [
            'user' => $user,
            'units' => $units,
            'title' => 'Kelola Profile'
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'sap' => 'required|string|max:255',
            'level_user' => 'required|string|max:255',
            'kodeunit' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed', 
        ]);

        $user->username = $request->username;
        $user->sap = $request->sap;
        $user->level_user = $request->level_user;
        $user->kodeunit = $request->kodeunit;

        // update password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile berhasil diperbarui.');
    }
}
