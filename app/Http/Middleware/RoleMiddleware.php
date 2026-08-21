<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Semak jika pengguna belum log masuk atau peranan (role) tidak sepadan
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Halang akses dan tunjuk ralat 403 (Forbidden)
            abort(403, 'Maaf, anda tidak mempunyai kebenaran untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}