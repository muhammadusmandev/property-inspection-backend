<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Exempt From auto bindings only add repository (file name/class name)
     * Ex: ['BillingRepository', 'UserRepository']
     */
    protected array $exemptAutoBindings = [''];

    /**
     * Register contracts with Repositories.
     */
    public function register(): void
    {
        // Todo: resolveAutoBindings() need to cached repeating same function
        foreach ($this->resolveAutoBindings() as $contract => $repository) {
            $this->app->bind($contract, $repository);
        }

        /* 
         * Manual bindings (If not following the naming conventions)
         * 
         * $this->app->bind("App\\Repositories\\Contracts\\UserRepository", "App\\Repositories\\ActiveUserRepository");
         */
    }

    /**
     * Get the repositories provided by the provider.
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
         * $manualBindings = ["App\\Repositories\\Contracts\\UserRepository"];
         * 
         */

        $manualBindings = [];

        return array_merge($manualBindings, array_keys($bindings));
    }

    protected function resolveAutoBindings(): array
    {
        $bindings = [];

        // Auto binding contracts with repositories based on naming.
        $repositoryFiles = glob(app_path('Repositories') . '/*.php');  // Get all repository folder files with (.php)

        foreach ($repositoryFiles as $file) {
            $className = pathinfo($file, PATHINFO_FILENAME);  // class name without (.php) extension
    
            if (in_array($className, $this->exemptAutoBindings)) {
                continue;
            }

            $repositoryClass = "App\\Repositories\\{$className}";
            $interfaceClass = "App\\Repositories\\Contracts\\{$className}";

            // Bind them on both existance
            if (class_exists($repositoryClass) && interface_exists($interfaceClass)) {
                $bindings[$interfaceClass] = $repositoryClass;
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
