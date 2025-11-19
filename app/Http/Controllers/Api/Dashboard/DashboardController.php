<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\Contracts\DashboardService as DashboardServiceContract;
use App\Traits\{ Loggable, ApiJsonResponse };

class DashboardController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected $dashboardService;

    /**
     * Inject DashboardServiceContract via constructor.
     * @param \App\Services\Contracts\DashboardService $dashboardService
    */
    public function __construct(DashboardServiceContract $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Get dashboard data
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->dashboardService->getDashboardData();
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_fetch_failed', ['resource' => 'Dashboard']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage()
            ], 500);
            
        }
    }
}
