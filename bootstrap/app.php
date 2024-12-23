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
        //
        header("Content-Security-Policy: img-src 'self' https://*.paypal.com https://*.paypalobjects.com https://*.paypal.cn https://ak1s.abmr.net https://*.math.tag.com https://googleads.g.doubleclick.net https://www.facebook.com https://www.google-analytics.com https://px.ads.linkedin.com;");

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
