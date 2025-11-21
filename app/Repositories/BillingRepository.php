<?php

namespace App\Repositories;

use App\Repositories\Contracts\BillingRepository as BillingRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use App\Models\SubscriptionPlan;

class BillingRepository implements BillingRepositoryContract
{
    /**
     * Get subscription plans with features
     *
     * @return Collection $plans
     */
    public function getSubscriptionPlans(): Collection
    {
        $plans = SubscriptionPlan::where('is_active', 1)
            ->with('features')
            ->get();

        return $plans;
    }
}