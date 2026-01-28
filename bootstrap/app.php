<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (\Illuminate\Foundation\Configuration\Middleware $middleware) {
    $middleware->alias([
        'api.customer' => \App\Http\Middleware\ApiCustomerOnly::class,
        'api.admin' => \App\Http\Middleware\ApiAdminOnly::class,
        'rider' => \App\Http\Middleware\RiderMiddleware::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'role'  => \App\Http\Middleware\RoleMiddleware::class, 
    ]);
})

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
