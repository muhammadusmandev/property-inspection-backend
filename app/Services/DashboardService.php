<?php

namespace App\Services;

use App\Services\Contracts\DashboardService as DashboardServiceContract;
use App\Resources\{ DashboardResource };

class DashboardService implements DashboardServiceContract
{
    /**
     * Get dashboard data
     *
     * @return \Illuminate\Http\JsonResponse|DashboardResource
     * 
     */
    public function getDashboardData(): DashboardResource
    {
        $user = auth()->user();

        if (!$user) {
            throw new \Exception('Oops! You are not authenticated');
        }

        return new DashboardResource($user);
    }
}
