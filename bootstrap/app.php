<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
   ->withRouting(
      web: __DIR__ . '/../routes/web.php',
      commands: __DIR__ . '/../routes/console.php',
      health: '/up',
   )
   ->withMiddleware(function (Middleware $middleware): void {
      //
   })
   ->withExceptions(function (Exceptions $exceptions): void {
      $exceptions->render(function (Throwable $e, Request $request) {
         if ($request->is('api/*')) {

            if ($e instanceof AuthenticationException) {
               return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            if ($e instanceof AuthorizationException) {
               return response()->json(['error' => 'Forbidden. You do not have permission to access this resource.'], 403);
            }

            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
               return response()->json(['error' => 'Resource not found.'], 404);
            }

            if ($e instanceof ValidationException) {
               return response()->json([
                  'error' => 'Validation failed.',
                  'details' => $e->errors(),
               ], 422);
            }

            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

            if (config('app.debug')) {
               return response()->json([
                  'error' => 'Server Error',
                  'message' => $e->getMessage(),
                  'trace' => $e->getTraceAsString(),
               ], $statusCode > 0 ? $statusCode : 500);
            }

            return response()->json(['error' => 'Server Error.'], $statusCode > 0 ? $statusCode : 500);
         }

         // For non-API requests, use default behavior
         return null;
      });
   })->create();
