<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiJsonResponse
{
    /**
     * Return a success JSON response.
     *
     * @param  string  $message
     * @param  mixed   $data
     * @param  int     $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse( string $message = 'Action done successfully.', $data = null, int $code = 200 ): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return a error JSON response.
     *
     * @param  string  $message
     * @param  mixed   errors
     * @param  int     $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse( string $message = 'Oops! Something went wrong.', $errors = null, int $code = 500 ): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}