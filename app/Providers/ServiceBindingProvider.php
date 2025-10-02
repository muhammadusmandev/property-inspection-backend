<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ServiceBindingProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Exempt From auto bindings only add service (file name/class name)
     * Ex: ['BillingService', 'UserService']
     */
    protected array $exemptAutoBindings = [''];

    /**
     * Register contracts with services.
     */
    public function register(): void
    {
        // Todo: resolveAutoBindings() need to cached repeating same function
        foreach ($this->resolveAutoBindings() as $contract => $service) {
            $this->app->bind($contract, $service);
        }

        /* 
         * Manual bindings (If not following the naming conventions)
         * 
         * $this->app->bind("App\\Services\\Contracts\\UserService", "App\\Services\\ActiveUserService");
         */
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        $bindings = $this->resolveAutoBindings();

        /* 
         * Manual bindings (If not following the naming conventions)
         *
         * Example Binding (also binding contract names in $manualBindings[] like below):
         * 
         * $manualBindings = ["App\\Services\\Contracts\\UserService"];
         */

        $manualBindings = [];

        return array_merge($manualBindings, array_keys($bindings));
    }

    protected function resolveAutoBindings(): array
    {
        $bindings = [];

        // Auto binding contracts with services based on naming.
        $serviceFiles = glob(app_path('Services') . '/*.php');  // Get all service folder files with (.php)

        foreach ($serviceFiles as $file) {
            $className = pathinfo($file, PATHINFO_FILENAME);  // class name without (.php) extension
    
            if (in_array($className, $this->exemptAutoBindings)) {
                continue;
            }

            $serviceClass = "App\\Services\\{$className}";
            $interfaceClass = "App\\Services\\Contracts\\{$className}";

            // Bind them on both existance
            if (class_exists($serviceClass) && interface_exists($interfaceClass)) {
                $bindings[$interfaceClass] = $serviceClass;
            }
        }

        return $bindings;
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
