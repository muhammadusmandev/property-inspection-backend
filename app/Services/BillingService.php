<?php

namespace App\Services;

use App\Services\Contracts\BillingService as BillingServiceContract;
use App\Repositories\Contracts\BillingRepository as BillingRepositoryContract;
use Illuminate\Auth\Access\AuthorizationException;
use App\Resources\{ ShowBillingResource };

class BillingService implements BillingServiceContract
{
    protected $billingRepository;

    /**
     * Inject BillingRepositoryContract via constructor.
     * @param \App\Repositories\Contracts\BillingRepository $billingRepository
    */
    public function __construct(BillingRepositoryContract $billingRepository)
    {
        $this->billingRepository = $billingRepository;
    }

    /**
     * Get billing related data to show on billing page.
     *
     * @return \Illuminate\Http\JsonResponse|ShowBillingResource
     * 
     */
    public function showBillingData(): ShowBillingResource
    {
        $user = auth()->user();

        // check if trial available or already used
        if (!$user->onTrial() && $user->subscribed('default')){
            throw new AuthorizationException(__('validationMessages.already_subscribe_but_try_billing'));
        }

        $plans = $this->billingRepository->getSubscriptionPlans();

        return new ShowBillingResource($plans);
    }
}
