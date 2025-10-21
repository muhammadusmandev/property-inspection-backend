<?php
namespace App\Services;

use App\Models\Branch;
use App\Repositories\Contracts\BranchRepository;
use App\Resources\BranchResource;
use App\Services\Contracts\BranchService as BranchServiceContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BranchService implements BranchServiceContract
{
    protected BranchRepository $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function listBranches(): AnonymousResourceCollection
    {
        return $this->branchRepository->getAllForUser(Auth::id());
    }

    public function createBranch(array $data): Branch
    {
        $data['user_id'] = Auth::id();
        return $this->branchRepository->create($data);
    }

    public function showBranch(int $id): BranchResource
    {
        $branch = $this->branchRepository->findById($id);

        if (!$branch) {
            throw new \Exception('Branch not found.');
        }

        if ($branch->user_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return new BranchResource($branch);
    }

    public function updateBranch(int $id, array $data): Branch
    {
        $branch = $this->branchRepository->findById($id);

        if (!$branch) {
            throw new \Exception('Branch not found.');
        }

        if ($branch->user_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return $this->branchRepository->update($branch, $data);
    }

    public function deleteBranch(int $id): void
    {
        $branch = $this->branchRepository->findById($id);

        if (!$branch) {
            throw new \Exception('Branch not found.');
        }

        if ($branch->user_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        $this->branchRepository->delete($branch);
    }
}
