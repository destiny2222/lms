<?php

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectTo(
            guests: function (Request $request) {
                if ($request->is('admin*')) {
                    return route('admin.login');
                }

                return route('login');
            },
            users: function () {
                if (auth('admin')->check()) {
                    return route('admin.dashboard');
                }

                /** @var User|null $user */
                $user = auth()->user();
                if ($user && ($user->isAdmin() || $user->isTutor())) {
                    return route('admin.dashboard');
                }

                return route('student.dashboard');
            },
        );

        $middleware->validateCsrfTokens(except: [
            'api/whatsapp/webhook',
            'webhook/whatsapp',
        ]);

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
