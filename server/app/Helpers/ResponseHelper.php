<?php

namespace App\Helpers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Exception;
use Illuminate\Http\JsonResponse;
use Nette\Utils\Helpers;

class ResponseHelper extends Helpers
{
    public static function handleException(Exception $e, $defaultMessage = 'An error occurred'): JsonResponse
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'error' => 'Validation error',
                'messages' => $e->errors()
            ], 422);
        }

        if ($e instanceof AuthenticationException) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json(['error' => 'Endpoint not found'], 404);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => 'Method not allowed'], 405);
        }

        return response()->json([
            'error' => $defaultMessage,
            'message' => $e->getMessage(),
        ], 500);
    }
}
