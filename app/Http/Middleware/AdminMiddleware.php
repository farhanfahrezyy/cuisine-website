<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login dan rolenya admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            Auth::logout();
            return redirect()->route('user.login.form')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin');
        }

        return $next($request);
    }
}
