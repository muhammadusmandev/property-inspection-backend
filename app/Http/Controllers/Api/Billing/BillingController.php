<?php

namespace App\Http\Controllers\Api\Billing;

use App\Http\Controllers\Controller;
use App\Services\Contracts\BillingService as BillingServiceContract;
use Illuminate\Auth\Access\AuthorizationException;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Exception\ApiErrorException;
use App\Requests\StoreActivateSubscriptionRequest;
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

    /**
     * Save stripe payment method and create activate subscription.
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception unexpected error
     */
    public function activateSubscription(StoreActivateSubscriptionRequest $request): JsonResponse
    {
        try {
            $status = $this->billingService->activateSubscription($request->validated());
            
            return $this->successResponse('Subscription activated successfully');
        } catch (IncompletePayment $e) {
            // Todo: must send this billing data incase in any of exception
            $this->logException($e, 'Incomplete payment, user action required for user:' . $request->user()->id . ' original message:' . $e->getMessage());
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => 'Payment requires additional authentication.',
            ], 500);
        } catch (ApiErrorException $e) {
            $this->logException($e, 'Stripe API error for User:' . $request->user()->id . ' original message:' . $e->getMessage());
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => 'We encountered a problem while processing your payment. Please try again later.',
            ], 500);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_create_failed', ['resource' => 'Activate Subscription']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get user subscription status
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function subscriptionStatus(): JsonResponse
    {
        try {
            $data = $this->billingService->subscriptionStatus();

            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.something_went_wrong'),[
                'error' => $e->getMessage()
            ], 403);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_fetch_failed', ['resource' => 'Subscription Status']));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
