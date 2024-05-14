<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Global middleware...
    ];

    protected $middlewareGroups = [
        'web' => [
            // Middleware that applies to web routes...
        ],

        'api' => [
            // Middleware that applies to API routes...
        ],
    ];

    protected $routeMiddleware = [
        'admin' => \App\Http\Middleware\AdminCheck::class,
    ];
}
