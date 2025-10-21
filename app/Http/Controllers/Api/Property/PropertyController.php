<?php

namespace App\Http\Controllers\Api\Property;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\Auth\Access\AuthorizationException;
use App\Services\Contracts\PropertyService as PropertyServiceContract;
use App\Requests\{ StorePropertyRequest, UpdatePropertyRequest };
use App\Traits\{ Loggable, ApiJsonResponse };

class PropertyController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected PropertyServiceContract $propertyService;

    /**
     * Inject PropertyServiceContract.
     */
    public function __construct(PropertyServiceContract $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    /**
     * Get all properties for the logged-in user.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->propertyService->listProperties();

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
    public function store(StorePropertyRequest $request): JsonResponse
    {
        try {
            $data = $this->propertyService->createProperty($request->validated());

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
            $data = $this->propertyService->showProperty($id);

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
    public function update(UpdatePropertyRequest $request, int $id): JsonResponse
    {
        try {
            $data = $this->propertyService->updateProperty($id, $request->validated());

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
            $this->propertyService->deleteProperty($id);

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
