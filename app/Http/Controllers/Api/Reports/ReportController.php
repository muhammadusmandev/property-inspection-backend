<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Requests\{ StoreReportRequest, UpdateReportRequest, UpdateReportChecklistRequest };
use App\Traits\ApiJsonResponse;
use App\Traits\Loggable;
use Illuminate\Auth\Access\AuthorizationException;
use App\Services\Contracts\ReportService as ReportServiceContract;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected ReportServiceContract $reportService;

    /**
     * Inject reportServiceContract.
     */
    public function __construct(ReportServiceContract $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Get all properties for the logged-in user.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->reportService->listReports()->response()->getData(true);
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_fetch_failed', ['resource' => 'Inspection Area']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a new report.
     */
    public function store(StoreReportRequest $request): JsonResponse
    {
        try {
            $data = $this->reportService->createReport($request->validated());

            return $this->successResponse(
                __('validationMessages.resource_created_successfully'),
                $data,
                200
            );

        } catch (QueryException $qe) {
            $this->logException($qe, __('validationMessages.resource_create_failed', ['resource' => 'Report']));

            return $this->errorResponse(__('validationMessages.resource_create_failed', ['resource' => 'Report']), [
                'error' => $qe->getMessage(),
            ], 500);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_create_failed', ['resource' => 'Report']));

            return $this->errorResponse(__('validationMessages.resource_create_failed', ['resource' => 'Report']), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show report details.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->reportService->showReport($id);

            return $this->successResponse(
                __('validationMessages.report.retrieved_successfully'),
                $data
            );

        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.unauthorized_access'), [
                'error' => $e->getMessage(),
            ], 403);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.report.show_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing report.
     */
    public function update(UpdateReportRequest $request, int $id): JsonResponse
    {
        // dd($request->all());
        try {
            $data = $this->reportService->updateReport($id, $request->validated());
            return $this->successResponse(__('validationMessages.resource_updated_successfully'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_update_failed', ['resource' => 'Template']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a report.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->reportService->deleteReport($id);

            return $this->successResponse(
                __('Report deleted successfully.')
            );

        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.unauthorized_access'), [
                'error' => $e->getMessage(),
            ], 403);

        } catch (\Exception $e) {
            $this->logException($e, __('Report deleted failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Todo: Move to separate service and controller
     * Update report checklist item.
     */
    public function updateCheckList(UpdateReportChecklistRequest $request): JsonResponse
    {
        try {
            $data = $this->reportService->updateReportChecklist($request->validated());
            return $this->successResponse(__('validationMessages.resource_updated_successfully'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_update_failed', ['resource' => 'Checklist']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate and lock/non-editable report.
     * @param int $id
     */
    public function generateReport(int $id): JsonResponse
    {
        try {
            $data = $this->reportService->generateReport($id);
            return $this->successResponse(__('validationMessages.report.report_generation_queued'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.report.report_generated_failure'));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check report status for report (Todo: Temp for polling need implement realtime).
     * @param int $id
     */
    public function checkReportStatus(int $id): JsonResponse
    {
        try {
            $data = $this->reportService->checkReportStatus($id);
            return $this->successResponse(__('validationMessages.report.report_status_success'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.report.report_status_failure'));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
