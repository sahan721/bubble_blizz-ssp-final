<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\EnsureTwoFactorVerified;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register middleware aliases for Laravel 12
        $this->app['router']->aliasMiddleware('EnsureTwoFactorVerified', EnsureTwoFactorVerified::class);
    }
}