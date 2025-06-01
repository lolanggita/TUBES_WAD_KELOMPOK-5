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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     * @param  string[]  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            // Jika belum login
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Cek apakah role user termasuk yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Access denied. You do not have access rights for this page.');
        }

        return $next($request);
    }
}
