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
            'sap' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $request->session()->put('id', Auth::user()->id);
            $request->session()->put('username', Auth::user()->username);
            $request->session()->put('level_user', Auth::user()->level_user);
            $request->session()->put('kodeunit', Auth::user()->kodeunit);

            if ($request->has('remember')) {
                cookie()->queue('remember_user', Auth::user()->id, 60 * 24 * 7);
            }

            return redirect()->intended('dashboard');
        }

        return redirect()->route('login')->with('error', 'Login gagal! Sap atau password salah.');
    }

    public function register(Request $request)
    {
        
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil Logout.');
    }
}
