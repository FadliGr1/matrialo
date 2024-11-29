<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
{
    if (!auth()->check()) {
        return redirect('login');
    }

    // Ubah string roles menjadi array jika diperlukan
    $roles = is_string($roles) ? explode('|', $roles) : $roles;

    // Cek apakah role user termasuk dalam role yang diizinkan
    if (!in_array(auth()->user()->role, $roles)) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    return $next($request);
}

}