<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::check() || $request->session()->has('username')) {
            // User sudah login, redirect ke dashboard
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}

