<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = strtolower((string) (Auth::user()->role ?? ''));

        if ($role !== 'admin') {
            abort(403, 'Only admins can access this area.');
        }

        return $next($request);
    }
}
