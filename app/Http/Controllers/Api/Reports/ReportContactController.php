<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\Contracts\ReportContactService as ReportContactServiceContract;
use App\Requests\{ 
    ReportContactStoreRequest, 
    ReportContactUpdateRequest 
};
use App\Traits\{ Loggable, ApiJsonResponse };

class ReportContactController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected $reportContactService;

    /**
     * Inject ReportContactServiceContract via constructor.
     * @param \App\Services\Contracts\ReportContactService $reportContactService
    */
    public function __construct(ReportContactServiceContract $reportContactService)
    {
        $this->reportContactService = $reportContactService;
    }

    /**
     * List contacts for given report.
     * @param int $reportId
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function index(int $reportId): JsonResponse
    {
        try {
            $data = $this->reportContactService->list($reportId);
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_fetch_failed', ['resource' => 'Report Contact']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store new report contact.
     * 
     * @param ReportContactStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     * 
     */
    public function store(ReportContactStoreRequest $request): JsonResponse
    {
        try {
            $data = $this->reportContactService->create($request->validated());
            return $this->successResponse(__('validationMessages.resource_created_successfully'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_create_failed', ['resource' => 'Report Contact']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update report contact.
     * 
     * @param ReportContactUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     * 
     */
    public function update(ReportContactUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $data = $this->reportContactService->update($id, $request->validated());
            return $this->successResponse(__('validationMessages.resource_updated_successfully'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_update_failed', ['resource' => 'Report Contact']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show report contact.
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     * 
     */
    public function show(string $id): JsonResponse
    {
        try {
            $data = $this->reportContactService->showContact($id);
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_fetch_failed', ['resource' => 'Report Contact']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete report contact.
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->reportContactService->delete($id);
            return $this->successResponse('Report Contact deleted successfully.');

        } catch (\Exception $e) {
            $this->logException($e, 'Report Contact delete failed.');
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
