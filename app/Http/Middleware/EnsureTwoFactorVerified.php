<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // If user is authenticated and has 2FA enabled
        if ($user && $user->two_factor_enabled) {
            // Check if there's a pending 2FA verification in session
            // This would mean they logged in but haven't completed 2FA yet
            if (session()->has('2fa_user_id')) {
                Auth::logout();
                return redirect()->route('2fa.verify');
            }
        }

        return $next($request);
    }
}
