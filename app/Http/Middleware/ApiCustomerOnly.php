<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiCustomerOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (($request->user()->role ?? '') !== 'customer') {
            return response()->json([
                'message' => 'Forbidden: customers only'
            ], 403);
        }

        return $next($request);
    }
}
