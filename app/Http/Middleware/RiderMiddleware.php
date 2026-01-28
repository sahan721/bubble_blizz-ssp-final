<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RiderMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1️⃣ Ensure user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2️⃣ Ensure role is rider
        $user = Auth::user();

        if (strtolower((string) $user->role) !== 'rider') {
            abort(403, 'Only riders can access this area.');
        }

        // 3️⃣ Allow request
        return $next($request);
    }
}
