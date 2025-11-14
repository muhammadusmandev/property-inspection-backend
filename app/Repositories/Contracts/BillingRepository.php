<?php

namespace App\Repositories\Contracts;
use Illuminate\Database\Eloquent\Collection;

interface BillingRepository
{
    /**
     * Get subscription plans with features
     *
     * @return Collection $plans
     */
    public function getSubscriptionPlans(): Collection;
}
