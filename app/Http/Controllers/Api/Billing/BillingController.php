<?php

namespace App\Http\Controllers\Api\Billing;

use App\Http\Controllers\Controller;
use App\Services\Contracts\BillingService as BillingServiceContract;
use Illuminate\Auth\Access\AuthorizationException;
use App\Traits\ApiJsonResponse;
use App\Traits\Loggable;
use Illuminate\Http\JsonResponse;

class BillingController extends Controller
{
    use ApiJsonResponse, Loggable;

    /**
     * Inject BillingServiceContract via constructor.
     * @param \App\Services\Contracts\BillingService $billingService
    */
    protected BillingServiceContract $billingService;

    public function __construct(BillingServiceContract $billingService)
    {
        $this->billingService = $billingService;
    }

    /**
     * Get billing related data to show on billing page.
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception unexpected error
     */
    public function showBillingData(): JsonResponse
    {
        try {
            $data = $this->billingService->showBillingData();

            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.something_went_wrong'),[
                'error' => $e->getMessage()
            ], 403);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_fetch_failed', ['resource' => 'Show Billing Data']));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
