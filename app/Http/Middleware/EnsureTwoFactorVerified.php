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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // If 2FA is enabled but not verified
            if ($user->two_factor_enabled && !session('2fa.verified')) {
                // Store the intended URL
                if (!$request->is('two-factor*')) {
                    session(['2fa.intended' => $request->url()]);
                }
                
                return redirect()->route('two-factor.challenge');
            }
        }

        return $next($request);
    }
}