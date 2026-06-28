<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk mengakses sistem.');
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            // Redirect based on role if they try to cross access
            if ($user->isAdmin()) {
                return redirect('/admin/dashboard')->with('error', 'Anda tidak memiliki wewenang untuk mengakses halaman instansi.');
            } elseif ($user->isInstansi()) {
                return redirect('/instansi/dashboard')->with('error', 'Anda tidak memiliki wewenang untuk mengakses halaman admin.');
            }

            return redirect('/login')->with('error', 'Akses ditolak. Peran tidak dikenali.');
        }

        return $next($request);
    }
}
