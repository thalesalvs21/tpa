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
    ->withMiddleware(function (Middleware $middleware): void {
        // R4: registra o apelido do middleware
        $middleware->alias([
            'organizador' => \App\Http\Middleware\OrganizadorMiddleware::class, // trocar: apelido do contrato e nome da classe
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
