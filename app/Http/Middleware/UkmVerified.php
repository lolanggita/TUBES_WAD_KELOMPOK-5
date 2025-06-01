<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UkmVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->is_verified) {
            return redirect()->route('dashboard')
                ->with('error', 'Akun UKM Anda belum diverifikasi oleh administrator');
        }

        return $next($request);
    }
}