<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

            $request->session()->put('id', Auth::user()->id);
            $request->session()->put('username', Auth::user()->username);
            $request->session()->put('level_user', Auth::user()->level_user);

            if ($request->has('remember')) {
                cookie()->queue('remember_user', Auth::user()->id, 60 * 24 * 7);
            }

            return redirect()->intended('dashboard');
        }

        return redirect()->route('login')->with('error', 'Login gagal! Email atau password salah.');
    }

    public function register(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'username'   => 'required|string|max:255',
                'email'      => 'required|email|unique:users,email',
                'password'   => 'required|confirmed|min:6',
                'level_user' => 'required|string|max:255',
            ]);

            // Simpan user baru
            User::create([
                'username'   => $validated['username'],
                'email'      => $validated['email'],
                'password'   => bcrypt($validated['password']),
                'level_user' => $validated['level_user'],
            ]);

            // ✅ Setelah registrasi, redirect ke login + pesan success
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ✅ Kalau gagal validasi, tetap ke login tapi tab register terbuka
            return redirect()->route('login')
                ->withErrors($e->validator)
                ->withInput()
                ->with('showRegister', true);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil Logout.');
    }
}
