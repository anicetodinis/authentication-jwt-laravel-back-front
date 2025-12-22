<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware global para web
        $middleware->web(append: [
            \App\Http\Middleware\PassJwtTokenFromLocalStorage::class,
            \App\Http\Middleware\HandleJwtExceptions::class,
        ]);

        // Isentar rota /session de CSRF (é chamada logo após login com JWT válido)
        $middleware->validateCsrfTokens(except: [
            'session',            
            'session/logout',
        ]);

        $middleware->alias([
            // Aliases do Spatie para permissões
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'check_jwt' => \App\Http\Middleware\CheckJwtToken::class,
            'web_or_jwt_auth' => \App\Http\Middleware\EnsureWebOrJwtAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
