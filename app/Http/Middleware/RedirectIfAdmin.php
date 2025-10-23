<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login DAN memiliki role 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Jika ya, paksa redirect ke dasbor admin
            return redirect()->route('admin.dashboard');
        }

        // Jika bukan admin, biarkan dia melanjutkan ke tujuannya
        return $next($request);
    }
}
