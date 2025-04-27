<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Jika mencoba akses halaman login admin
                if ($guard === 'admin') {
                    if ($user->role === 'admin') {
                        return redirect()->route('admin.dashboard')
                            ->with('info', 'Anda sudah login sebagai admin.');
                    }
                    // Jika user biasa mencoba akses login admin, biarkan lanjut
                    return $next($request);
                }

                // Jika mencoba akses halaman login user biasa
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard')
                        ->with('info', 'Anda sudah login sebagai admin.');
                }

                return redirect()->route('home')
                    ->with('info', 'Anda sudah login sebagai user.');
            }
        }

        return $next($request);
    }
}
