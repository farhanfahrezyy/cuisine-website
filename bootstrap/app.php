<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware-> alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'preventBackHistory' => \App\Http\Middleware\PreventBackAfterLogout::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'checkRole' => \App\Http\Middleware\CheckRole::class,
            'BlockAdminAccess' => \App\Http\Middleware\BlockAdminAccess::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
