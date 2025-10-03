<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

trait Loggable
{
    /**
     * Log an exception with request and context information.
     *
     * @param  \Throwable  $e
     * @param  string  $context
     * @return void
     */
    public function logException($e, $context = 'API Exception'): void
    {
        Log::error(($context . ' : '), [
            'targetController' => __CLASS__ . '@' . debug_backtrace()[1]['function'],
            'requestPath' => request()->path(),
            'requestMethod' => request()->method(),
            'requestIP' => request()->ip() ?? 'N/A',
            'user_agent' => request()->userAgent() ?? 'N/A',
            'user_id' => auth()->user()->id ?? 'N/A',
            'requestPayload' => request()->all(),
            'errorMessage' => $e->getMessage(),
            'loggedAt' => now()->toDateTimeString(),
        ]);
    }
}