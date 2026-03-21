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
        // Redirect guests to appropriate login page based on guard
        $middleware->alias([
            'onlyAdmin' => \App\Http\Middleware\onlyAdmin::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'chatbot/*',                // all URLs starting with /stripe/
            'webhook/receive',         // exact match
            'api/external/*',          // wildcard example
            'https://example.com/pay/*',   // full external URL (rare)
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
