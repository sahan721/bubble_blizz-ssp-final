<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $actualRole = strtolower((string) ($user->role ?? ''));
        $allowed    = array_map(fn ($r) => strtolower((string) $r), $roles);

        if (!in_array($actualRole, $allowed, true)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
