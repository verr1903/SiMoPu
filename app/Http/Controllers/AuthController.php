<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Simpan username di session
            $request->session()->put('id', Auth::user()->id);
            $request->session()->put('username', Auth::user()->username);
            $request->session()->put('level_user', Auth::user()->level_user);

            // Contoh cookie "remember me" (opsional)
            if ($request->has('remember')) {
                cookie()->queue('remember_user', Auth::user()->id, 60 * 24 * 7); // 7 hari
            }

            return redirect()->intended('dashboard');
        }

        return redirect()->route('login')->with('error', 'Login gagal! Email atau password salah.');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
