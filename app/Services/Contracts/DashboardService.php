<?php

namespace App\Services\Contracts;

use App\Resources\DashboardResource;

interface DashboardService
{
    /**
     * Get dashboard data
     *
     * @return \Illuminate\Http\JsonResponse|DashboardResource
     * 
     */
    public function getDashboardData(): DashboardResource;
}