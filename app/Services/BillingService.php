<?php

namespace App\Services;

use App\Services\Contracts\BillingService as BillingServiceContract;
use App\Repositories\Contracts\BillingRepository as BillingRepositoryContract;
use Illuminate\Auth\Access\AuthorizationException;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Exception\ApiErrorException;
use App\Resources\{ ShowBillingResource };
use App\Models\UserBillingDetail;
use DB;

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

    /**
     * Save stripe payment method and create new activate subscription.
     *
     * @param array $billingData
     * @return void
     * 
     */
    public function activateSubscription(array $billingData): void
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();
            // attach payment method
            $user->updateDefaultPaymentMethod($billingData['stripe_payment_method']);

            // Create subscription and activate it
            if (!$user->subscribed('default')) {
                $user->newSubscription('default', $billingData['stripe_plan_price_id'])
                    ->create($billingData['stripe_payment_method']);
            }

            // Todo: Add in repository
            UserBillingDetail::create([
                "user_id" => $user->id,
                "stripe_payment_method" => $billingData['stripe_payment_method'],
                "name" => $billingData['name'],
                "email" => $billingData['email'],
                "address" => $billingData['address'],
                "address_2" => $billingData['address_2'],
                "city" => $billingData['city'],
                "country_code" => $billingData['country'],
                "postal_code" => $billingData['postal_code'],
                "state" => $billingData['state']
            ]);

            DB::commit();
        } catch (IncompletePayment $e) {
            // Cases where 3D Secure/SCA is required
            DB::rollBack();
            throw $e;

        } catch (ApiErrorException $e) {
            DB::rollBack();
            throw $e;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;

        }
    }
}
