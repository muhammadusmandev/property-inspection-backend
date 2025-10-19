<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\LoginPreconditionException;

class GateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(App\Models\User::class, App\Policies\AuthPolicy::class);

        Gate::define('allow-login', function ($user) {
            if (!$user->is_active) {
                throw new LoginPreconditionException(__('validationMessages.inactive_account'), 'inactive');
            }

            if (is_null($user->email_verified_at)) {
                throw new LoginPreconditionException(__('validationMessages.email.email_verified'), 'email_non_verified');
            }

            return true;
        });
    }
}
