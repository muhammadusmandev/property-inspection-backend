<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Requests\StoreReportRequest;
use App\Requests\UpdateReportRequest;
use App\Traits\ApiJsonResponse;
use App\Traits\Loggable;
use Illuminate\Auth\Access\AuthorizationException;
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
            $data = $this->reportService->listreports();

            return $this->successResponse(
                __('validationMessages.property.list_success'),
                $data
            );

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.property.list_failed'));

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
        try {
            $data = $this->reportService->createProperty($request->validated());

            return $this->successResponse(
                __('validationMessages.property.created_successfully'),
                $data,
                201
            );

        } catch (QueryException $qe) {
            $this->logException($qe, __('validationMessages.data_saved_failed'));

            return $this->errorResponse(__('validationMessages.data_saved_failed'), [
                'error' => $qe->getMessage(),
            ], 500);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.property.create_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
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
            $this->reportService->deleteProperty($id);

            return $this->successResponse(
                __('validationMessages.property.deleted_successfully')
            );

        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.unauthorized_access'), [
                'error' => $e->getMessage(),
            ], 403);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.property.delete_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
