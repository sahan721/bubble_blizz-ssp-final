<?php

namespace App\Actions\Fortify;

use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        // ✅ remove any "intended" redirect like /dashboard
        $request->session()->forget('url.intended');

        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // ✅ ALWAYS go by role (NOT intended)
        return match ($user->role) {
            'admin' => redirect()->to('/admin/home'),
            'rider' => redirect()->to('/rider/home'),
            default => redirect()->to('/customer/home'),
        };
    }
}
