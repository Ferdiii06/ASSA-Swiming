<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Coach dan Admin langsung aktif tanpa persetujuan
            if (in_array($user->role, ['admin', 'coach'])) {
                if ($user->status !== 'active') {
                    $user->update(['status' => 'active']);
                }
                return $next($request);
            }

            if ($user->status === 'pending') {
                return redirect()->route('approval.notice');
            }
        }

        return $next($request);
    }
}
