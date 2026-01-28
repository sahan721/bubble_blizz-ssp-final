<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $role = strtolower((string) (Auth::user()->role ?? ''));

        if ($role !== 'admin') {
            return response()->json(['message' => 'Only admins can access this endpoint'], 403);
        }

        return $next($request);
    }
}