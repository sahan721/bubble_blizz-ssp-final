<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;

use App\Models\User;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;

use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Fortify responses (Laravel 12 reliable)
        $this->app->singleton(LoginResponseContract::class, \App\Actions\Fortify\LoginResponse::class);
        $this->app->singleton(RegisterResponseContract::class, \App\Actions\Fortify\RegisterResponse::class);
    }

    public function boot(): void
    {
        // ✅ FIX: Define Fortify rate limiters used by throttle:login and throttle:two-factor
        $this->configureRateLimiting();

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        // ✅ Role + credentials check
        Fortify::authenticateUsing(function (Request $request) {

            $request->validate([
                'email'    => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
                'role'     => ['required', 'in:admin,customer,rider'],
            ]);

            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {

                $selectedRole = strtolower((string) $request->role);
                $actualRole   = strtolower((string) ($user->role ?? ''));

                if ($selectedRole !== $actualRole) {
                    throw ValidationException::withMessages([
                        'role' => 'Selected role does not match this account.',
                    ]);
                }

                return $user;
            }

            return null;
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->input('email');

            // 5 attempts per minute per (email + ip)
            return Limit::perMinute(5)->by($email . '|' . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            // 5 attempts per minute per session login id
            return Limit::perMinute(5)->by((string) $request->session()->get('login.id'));
        });
    }
}
