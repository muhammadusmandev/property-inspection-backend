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
            $data = $this->templateService->listTemplates();
            return $this->successResponse('Templates retrieved successfully.', $data);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch templates.', ['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreTemplateRequest $request): JsonResponse
    {
        try {
            $data = $this->templateService->createTemplate($request->validated());
            return $this->successResponse('Template created successfully.', $data, 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to create template.', ['error' => $e->getMessage()], 500);
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
            return $this->successResponse('Template updated successfully.', $data);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update template.', ['error' => $e->getMessage()], 500);
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
