<?php

namespace App\Http\Controllers\Api\Media;

use App\Http\Controllers\Controller;
use App\Traits\ApiJsonResponse;
use App\Traits\Loggable;
use App\Services\Contracts\MediaService as MediaServiceContract;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected MediaServiceContract $mediaService;

    /**
     * Inject PropertyServiceContract.
     */
    public function __construct(MediaServiceContract $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * Get all properties for the logged-in user.
     */
    public function index(): JsonResponse
    {
       
    }

    /**
     * Store a new property.
     */
    public function store(StoreReportRequest $request): JsonResponse
    {
        
    }

    /**
     * Show property details.
     */
    public function show(int $id): JsonResponse
    {
        
    }

    /**
     * Update an existing property.
     */
    public function update(UpdateReportRequest $request, int $id): JsonResponse
    {
        
    }

    /**
     * Delete a property.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->mediaService->deleteMedia($id);

            return $this->successResponse(
                __('Media deleted successfully.')
            );

        } catch (\Exception $e) {
            $this->logException($e, __('Media deleted failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
