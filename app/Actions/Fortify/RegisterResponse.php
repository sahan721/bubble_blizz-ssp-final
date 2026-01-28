<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        // Logout after register (stop auto-login)
        Auth::logout();

        // Redirect to login
        return redirect()->route('login')
            ->with('status', 'Registration successful. Please login.');
    }
}
    