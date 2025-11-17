<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Services\Contracts\ReportInspectionAreaDefectService;
use App\Requests\{ AddReportInspectionAreaDefectRequest, UpdateReportInspectionAreaDefectRequest };
use App\Traits\ApiJsonResponse;
use App\Traits\Loggable;
use Illuminate\Http\JsonResponse;

class ReportInspectionAreaDefectController extends Controller
{
    use ApiJsonResponse, Loggable;

    protected ReportInspectionAreaDefectService $reportInspectionAreaDefectService;

    /**
     * Inject ReportInspectionAreaDefectService.
     */
    public function __construct(ReportInspectionAreaDefectService $reportInspectionAreaDefectService)
    {
        $this->reportInspectionAreaDefectService = $reportInspectionAreaDefectService;
    }

    /**
     * Create a new report inspection area defect.
     */
    public function store(AddReportInspectionAreaDefectRequest $request): JsonResponse
    {
        try {
            $data = $this->reportInspectionAreaDefectService->addInspectionAreaDefect($request->validated());
            return $this->successResponse(__('validationMessages.resource_created_successfully'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_create_failed', ['resource' => 'Inspection Area Defect']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get details of a specific report inspection area defect by ID.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->reportInspectionAreaDefectService->showInspectionAreaDefect($id);
            return $this->successResponse('Report inspection area defect retrieved successfully.', $data);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve report inspection area defect.', [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an report inspection area defect.
     */
    public function updateDefect(UpdateReportInspectionAreaDefectRequest $request, int $id): JsonResponse
    {
        try {
            $data = $this->reportInspectionAreaDefectService->updateInspectionAreaDefect($id, $request->validated());
            return $this->successResponse(__('validationMessages.resource_updated_successfully'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_update_failed', ['resource' => 'Report Inspection Area Defect']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a report inspection area defect.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->reportInspectionAreaDefectService->deleteInspectionAreaDefect($id);
            return $this->successResponse('Report inspection area defect deleted successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete report inspection area defect.', [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
