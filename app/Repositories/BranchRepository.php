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
        $columnQuery = request()->input('columnQuery');
        $columnName = request()->input('columnName');

        $query = Branch::where('user_id', $userId)
            ->with('properties')
            ->latest();
        
        if ($columnName && $columnQuery) {
            if (str_contains($columnName, '.')) {      // search query on relation
                [$relation, $column] = explode('.', $columnName);

                $query->whereHas($relation, function ($q) use ($column, $columnQuery) {
                    $q->where($column, 'LIKE', "%{$columnQuery}%");
                });
            } else {
                $query->where($columnName, 'LIKE', "%{$columnQuery}%");
            }
        }

        // Todo: make trait/helper for getting boolean from request safely
        $paginate = filter_var(
            is_string($v = request()->input('paginate', true)) ? trim($v, "\"'") : $v,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        ) ?? true;

        if (!$paginate) {
            $branches = $query->get();
        } else{
            $branches = $query->paginate(request()->input('perPage') ?? $perPage);
        }

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
