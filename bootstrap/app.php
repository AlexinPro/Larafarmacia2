<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Aquí puedes registrar tus middlewares si es necesario
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if($request->is('api/laboratorios/*')){
                return response()->json([
                    'status' => false,
                    'message' => 'the lab id does not exists'
                ], 404);
            }
            if($request->is('api/medicamentos/*')){
                return response()->json([
                    'status' => false,
                    'message' => 'the med id does not exists'
                ], 404);
            }
            if($request->is('api/clientes/*')){
                return response()->json([
                    'status' => false,
                    'message' => 'the client id does not exists'
                ], 404);
            }
            if($request->is('api/empleados/*')){
                return response()->json([
                    'status' => false,
                    'message' => 'the employee id does not exists'
                ], 404);
            }
            if($request->is('api/ventas/*')){
                return response()->json([
                    'status' => false,
                    'message' => 'the sales id does not exists'
                ], 404);
            }
        });
    })
    ->create();
