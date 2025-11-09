<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Services\Contracts\ReportInspectionAreaService;
use App\Requests\{ AddReportInspectionAreaRequest, UpdateReportInspectionAreaRequest };
use App\Traits\ApiJsonResponse;
use App\Traits\Loggable;
use Illuminate\Http\JsonResponse;

class ReportInspectionAreaController extends Controller
{
    use ApiJsonResponse, Loggable;

    protected ReportInspectionAreaService $reportInspectionAreaService;

    /**
     * Inject ReportInspectionAreaService.
     */
    public function __construct(ReportInspectionAreaService $reportInspectionAreaService)
    {
        $this->reportInspectionAreaService = $reportInspectionAreaService;
    }

    /**
     * List all report inspection areas.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->reportInspectionAreaService
                ->listReportInspectionAreas()
                ->response()
                ->getData(true);

            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.report_inspection_areas_fetch_api_failed'));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create a new report inspection area.
     */
    public function store(AddReportInspectionAreaRequest $request): JsonResponse
    {
        try {
            $data = $this->reportInspectionAreaService->addReportInspectionArea($request->validated());
            return $this->successResponse(__('validationMessages.resource_created_successfully'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_create_failed', ['resource' => 'Report Inspection Area']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get details of a specific report inspection area by ID.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->reportInspectionAreaService->showReportInspectionArea($id);
            return $this->successResponse('Report inspection area retrieved successfully.', $data);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve report inspection area.', [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing report inspection area.
     */
    public function update(UpdateReportInspectionAreaRequest $request, int $id): JsonResponse
    {
        try {
            $data = $this->reportInspectionAreaService->updateReportInspectionArea($id, $request->validated());
            return $this->successResponse(__('validationMessages.resource_updated_successfully'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_update_failed', ['resource' => 'Report Inspection Area']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a report inspection area.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->reportInspectionAreaService->deleteReportInspectionArea($id);
            return $this->successResponse('Report inspection area deleted successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete report inspection area.', [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
