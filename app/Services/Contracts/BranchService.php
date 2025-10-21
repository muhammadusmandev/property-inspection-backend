<?php
namespace App\Services\Contracts;

use App\Resources\BranchResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Branch;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface BranchService
{
    public function listBranches(): AnonymousResourceCollection;

    public function createBranch(array $data): Branch;

    public function showBranch(int $id): BranchResource;

    public function updateBranch(int $id, array $data): Branch;

    public function deleteBranch(int $id): void;
}
