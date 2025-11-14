<?php

namespace App\Http\Controllers\Api\Template;

use App\Http\Controllers\Controller;
use App\Services\Contracts\TemplateService;
use App\Requests\StoreTemplateRequest;
use App\Requests\UpdateTemplateRequest;
use App\Traits\ApiJsonResponse;
use App\Traits\Loggable;
use Illuminate\Http\JsonResponse;

class TemplateController extends Controller
{
    use ApiJsonResponse, Loggable;

    protected TemplateService $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->templateService->listTemplates()->response()->getData(true);
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_fetch_failed', ['resource' => 'Inspection Area']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreTemplateRequest $request): JsonResponse
    {
        try {
            $data = $this->templateService->createTemplate($request->validated());
            return $this->successResponse(__('validationMessages.resource_created_successfully'), $data, 201);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_create_failed', ['resource' => 'Template']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->templateService->showTemplate($id);
            return $this->successResponse('Template retrieved successfully.', $data);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve template.', ['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateTemplateRequest $request, int $id): JsonResponse
    {
        try {
            $data = $this->templateService->updateTemplate($id, $request->validated());
            return $this->successResponse(__('validationMessages.resource_updated_successfully'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_update_failed', ['resource' => 'Template']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->templateService->deleteTemplate($id);
            return $this->successResponse('Template deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete template.', ['error' => $e->getMessage()], 500);
        }
    }
}
