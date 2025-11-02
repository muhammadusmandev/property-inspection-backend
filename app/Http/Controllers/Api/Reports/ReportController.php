<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Requests\StoreReportRequest;
use App\Requests\UpdateReportRequest;
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
     * Inject PropertyServiceContract.
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
     * Store a new property.
     */
    public function store(StoreReportRequest $request): JsonResponse
    {
        // dd($request->all());
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
     * Show property details.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->reportService->showProperty($id);

            return $this->successResponse(
                __('validationMessages.property.retrieved_successfully'),
                $data
            );

        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.unauthorized_access'), [
                'error' => $e->getMessage(),
            ], 403);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.property.show_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing property.
     */
    public function update(UpdateReportRequest $request, int $id): JsonResponse
    {
        try {
            $data = $this->reportService->updateProperty($id, $request->validated());

            return $this->successResponse(
                __('validationMessages.property.updated_successfully'),
                $data
            );

        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.unauthorized_access'), [
                'error' => $e->getMessage(),
            ], 403);

        } catch (QueryException $qe) {
            $this->logException($qe, __('validationMessages.data_saved_failed'));

            return $this->errorResponse(__('validationMessages.data_saved_failed'), [
                'error' => $qe->getMessage(),
            ], 500);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.property.update_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a property.
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
}
