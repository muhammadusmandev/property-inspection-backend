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

    /**
     * Save stripe payment method and create new activate subscription.
     *
     * @param array $billingData
     * @return void
     * 
     */
    public function activateSubscription(array $billingData): void;
}