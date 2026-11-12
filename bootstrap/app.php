<?php
use App\Http\Middleware\EnsureRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // [P11] route API otomatis berawalan /api.
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // [P09] Alias middleware kustom /role:admin di route web.
        $middleware->alias(['role' => EnsureRole::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // [P07, P11] Request API selalu mengembalikan JSON, bukan HTML error page.
        $exceptions->shouldRenderJsonWhen(fn (Request $request): bool =>
            $request->is('api/*') || $request->expectsJson()
        );
    })->create();
