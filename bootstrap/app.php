<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/service.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => App\Http\Middleware\CheckRole::class,
            'regular.user' => App\Http\Middleware\RegularUserMiddleware::class
        ]);

        $middleware->group('regular.user', [
            'auth',
            // 'user.active',
        ]);

        $middleware->group('admin', [
            'auth',
            'role', // check role admin
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
