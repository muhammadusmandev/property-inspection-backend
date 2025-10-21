<?php
namespace App\Http\Controllers\Api\Branch;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\Auth\Access\AuthorizationException;
use App\Services\Contracts\BranchService as BranchServiceContract;
use App\Requests\{ StoreBranchRequest, UpdateBranchRequest };
use App\Traits\{ Loggable, ApiJsonResponse };

class BranchController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected BranchServiceContract $branchService;

    public function __construct(BranchServiceContract $branchService)
    {
        $this->branchService = $branchService;
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->branchService->listBranches();
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.something_went_wrong'));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), ['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreBranchRequest $request): JsonResponse
    {
        try {
            $data = $this->branchService->createBranch($request->validated());
            return $this->successResponse(__('validationMessages.branch.created_successfully'), $data, 201);
        } catch (QueryException $qe) {
            $this->logException($qe, __('validationMessages.data_saved_failed'));
            return $this->errorResponse(__('validationMessages.data_saved_failed'), ['error' => $qe->getMessage()], 500);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.branch.create_failed'));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), ['error' => $e->getMessage()], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->branchService->showBranch($id);
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.something_went_wrong'));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), ['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateBranchRequest $request, int $id): JsonResponse
    {
        try {
            $data = $this->branchService->updateBranch($id, $request->validated());
            return $this->successResponse(__('validationMessages.branch.updated_successfully'), $data);
        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.unauthorized_access'), ['error' => $e->getMessage()], 403);
        } catch (QueryException $qe) {
            $this->logException($qe, __('validationMessages.data_saved_failed'));
            return $this->errorResponse(__('validationMessages.data_saved_failed'), ['error' => $qe->getMessage()], 500);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.something_went_wrong'));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), ['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->branchService->deleteBranch($id);
            return $this->successResponse(__('validationMessages.branch.deleted_successfully'));
        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.unauthorized_access'), ['error' => $e->getMessage()], 403);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.branch.delete_failed'));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), ['error' => $e->getMessage()], 500);
        }
    }
}
