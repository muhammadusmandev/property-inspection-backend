<?php

namespace App\Http\Controllers\Api\InspectionArea;

use App\Http\Controllers\Controller;
use App\Services\Contracts\InspectionAreaService;
use App\Requests\{ AddInspectionAreaRequest };
use App\Traits\ApiJsonResponse;
use App\Traits\Loggable;
use Illuminate\Http\JsonResponse;

class InspectionAreaController extends Controller
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
            $data = $this->inspectionAreaService->listInspectionAreas()->response()->getData(true);
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.inspection_areas_fetch_api_failed'));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), ['error' => $e->getMessage()], 500);
        }
    }

    public function store(AddInspectionAreaRequest $request): JsonResponse
    {
        try {
            $data = $this->inspectionAreaService->addInspectionArea($request->validated());

            return $this->successResponse(
                __('validationMessages.resource_created_successfully'),
                $data,
                200
            );

        } catch (QueryException $qe) {
            $this->logException($qe, __('validationMessages.data_saved_failed'));
            return $this->errorResponse(__('validationMessages.data_saved_failed'), [
                'error' => $qe->getMessage(),
            ], 500);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_create_failed', ['resource' => 'Inspection Area']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
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
