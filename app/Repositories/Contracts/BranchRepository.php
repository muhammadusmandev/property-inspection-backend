<?php
namespace App\Repositories\Contracts;

use App\Models\Branch;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface BranchRepository
{
    public function getAllForUser(int $userId, int $perPage = 10): AnonymousResourceCollection;

    public function findById(int $id): ?Branch;

    public function create(array $data): Branch;

    public function update(Branch $branch, array $data): Branch;

    public function delete(Branch $branch): bool;
}
