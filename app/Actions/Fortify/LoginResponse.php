<?php

namespace App\Actions\Fortify;

use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        
        $request->session()->forget('url.intended');

        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $role = strtolower(trim((string) $user->role));

        return match ($role) {
            'admin'    => redirect('/admin/dashboard'),
            'customer' => redirect('/home'),
            'rider'    => redirect('/rider/dashboard'),
            default    => redirect('/home'), 
        };
    }
}
