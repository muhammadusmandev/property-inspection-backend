<?php

namespace App\Http\Controllers\Api\InspectionArea;

use App\Http\Controllers\Controller;
use App\Services\Contracts\InspectionAreaService;
use App\Requests\{ AddInspectionAreaRequest, UpdateInspectionAreaRequest };
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
        try {
            $data = $this->inspectionAreaService->showInspectionArea($id);
            return $this->successResponse('Inspection area retrieved successfully.', $data);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve area.', ['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateInspectionAreaRequest $request, int $id): JsonResponse
    {
        try {
            $data = $this->inspectionAreaService->updateInspectionArea($id, $request->validated());
            return $this->successResponse(__('validationMessages.resource_updated_successfully'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_update_failed', ['resource' => 'Inspection Area']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->inspectionAreaService->deleteInspectionArea($id);
            return $this->successResponse('Inspection area deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete inspection area.', ['error' => $e->getMessage()], 500);
        }
    }
}
