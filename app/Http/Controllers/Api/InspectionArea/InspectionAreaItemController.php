<?php

namespace App\Http\Controllers\Api\InspectionArea;

use App\Http\Controllers\Controller;
use App\Services\Contracts\InspectionAreaService;
use App\Traits\ApiJsonResponse;
use App\Traits\Loggable;
use Illuminate\Http\JsonResponse;

class InspectionAreaItemController extends Controller
{
    use ApiJsonResponse, Loggable;

    protected InspectionAreaService $inspectionAreaService;

    public function __construct(InspectionAreaService $inspectionAreaService)
    {
        $this->inspectionAreaService = $inspectionAreaService;
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->inspectionAreaService->listInspectionAreaItems();
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.inspection_areas_fetch_api_failed'));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), ['error' => $e->getMessage()], 500);
        }
    }

    public function store(): JsonResponse
    {
        
    }

    public function show(int $id): JsonResponse
    {
        
    }

    public function update(UpdateTemplateRequest $request, int $id): JsonResponse
    {
        
    }

    public function destroy(int $id): JsonResponse
    {
        
    }
}
