<?php

namespace App\Listeners;

use App\Events\RegistrationOtpVerified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Traits\Loggable;
use Throwable;

class CreateStripeCustomer implements ShouldQueue
{
    use Loggable, InteractsWithQueue;

    /**
     * Max retry attempts.
     */
    public $tries = 3;

    /**
     * Backoff time between retries (seconds).
     */
    public $backoff = [30, 60];

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegistrationOtpVerified $event): void
    {
        $user = $event->user;

        try {
            if (!$user->hasStripeId()) {
                $user->createAsStripeCustomer();
            }
        } catch (Throwable $e) {
            $this->logException($e, "Stripe customer creation failed. User #{$user->id}");

            // Todo: Notify team if stripe customer create failed
        }
    }

    /**
     * Handle permanent failure after all retries.
     */
    public function failed(RegistrationOtpVerified $event, Throwable $e): void
    {
        $user = $event->user;

        $this->logException($e, "Stripe customer creation all tries failed. User #{$user->id}");

        // Todo: Notify team if stripe customer create all tries failed
    }
}
