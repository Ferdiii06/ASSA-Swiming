<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = $user->role ?? 'user';

        if (!in_array($userRole, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak.'], 403);
            }

            return redirect()->route('dashboard')->with('error', 'Akses ditolak: Akun Anda tidak memiliki izin untuk tindakan ini.');
        }

        return $next($request);
    }
}
