<?php
namespace App\Repositories;

use App\Models\Branch;
use App\Repositories\Contracts\BranchRepository as BranchRepositoryContract;
use App\Resources\BranchResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BranchRepository implements BranchRepositoryContract
{
    public function getAllForUser(int $userId, int $perPage = 10): AnonymousResourceCollection
    {
        $branches = Branch::where('user_id', $userId)
            ->with('properties')
            ->latest()
            ->paginate($perPage);

        return BranchResource::collection($branches);
    }

    public function findById(int $id): ?Branch
    {
        return Branch::with('properties')->find($id);

    }

    public function create(array $data): Branch
    {
        return Branch::create($data);
    }

    public function update(Branch $branch, array $data): Branch
    {
        $branch->update($data);
        return $branch;
    }

    public function delete(Branch $branch): bool
    {
        return $branch->delete();
    }
}
