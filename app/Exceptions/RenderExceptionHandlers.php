<?php

namespace App\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Carbon\CarbonInterval;
use Throwable;

class RenderExceptionHandlers
{
    /**
     * Register custom exception rendering callbacks.
     *
     * @param \Illuminate\Foundation\Configuration\Exceptions $exceptions
     * 
     * @return void
     */
    public static function register(Exceptions $exceptions): void
    {
        // Handle rate limit
        $exceptions->renderable(function (Throwable $e, Request $request) {
            if ($e instanceof ThrottleRequestsException) {
                if ($request->expectsJson()) {
                    $retryAfter = (int) $e->getHeaders()['Retry-After'] ?? 0;

                    // Format retry time human friendly
                    $retryAfterFormatted = CarbonInterval::seconds($retryAfter)
                                            ->cascade()
                                            ->forHumans(['parts' => 1]);

                    return response()->json([
                        "success" => false,
                        "message" => __('validationMessages.something_went_wrong'),
                        "errors" => ["error" => __('validationMessages.request_limit_exceeded' , ['retryTime' => $retryAfterFormatted])]
                    ], 429);
                }
            }
            return null;
        });
    }
}
