<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Role constants untuk menghindari string literals
     */
    private const ROLE_ADMIN = 'admin';
    private const ROLE_USER = 'user';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $currentUser = Auth::guard($guard)->user();
                $currentRole = $currentUser->role;

                // Jika user adalah admin, hanya boleh akses route yang dimulai dengan 'admin'
                if ($currentRole === self::ROLE_ADMIN) {
                    if (!$request->is('admin/*') && !$request->is('admin')) {
                        return redirect()->route('admin.dashboard')
                            ->with('warning', 'Admin hanya bisa mengakses halaman admin');
                    }
                }

                // Jika user adalah user biasa, tidak boleh akses route admin
                if ($currentRole === self::ROLE_USER) {
                    if ($request->is('admin/*') || $request->is('admin')) {
                        Auth::guard($guard)->logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();

                        return redirect()->route('user.login')
                            ->with('error', 'Anda tidak memiliki akses ke halaman admin');
                    }
                }

                // Redirect ke dashboard sesuai role jika mencoba akses halaman login
                if ($request->is('*/login')) {
                    return $this->redirectToDashboard($currentRole);
                }
            }
        }

        return $next($request);
    }

    /**
     * Redirect user ke dashboard berdasarkan role.
     *
     * @param string $role Role pengguna
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function redirectToDashboard(string $role): Response
    {
        return match($role) {
            self::ROLE_ADMIN => redirect()->route('admin.dashboard')
                        ->with('info', 'Anda sudah login sebagai admin'),
            default => redirect()->route('home')
                        ->with('info', 'Anda sudah login sebagai user'),
        };
    }
}
