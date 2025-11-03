<?php

namespace App\Services\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Resources\{ ShowBillingResource };

interface BillingService
{
    /**
     * Get billing related data to show on billing page.
     *
     * @return \Illuminate\Http\JsonResponse|ShowBillingResource
     * 
     */
    public function showBillingData(): ShowBillingResource;
}