<?php

use App\Http\Middleware\AdminPermissionsMiddleware;
use App\Http\Middleware\AiApiClientMiddleware;
use App\Http\Middleware\ThirdPartyApiThrottleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->prepend('web', [
        //     AdminRedirectIfAuthenticatedMiddleware::class
        // ]);
        $middleware->alias([
            'hasPermission' => AdminPermissionsMiddleware::class,
            'tpThrottle' => ThirdPartyApiThrottleMiddleware::class,
            'aiClient' => AiApiClientMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
