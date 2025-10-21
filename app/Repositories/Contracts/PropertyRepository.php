<?php

namespace App\Repositories\Contracts;

use App\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface PropertyRepository
{
    public function getAllForUser(int $userId, int $perPage = 10): AnonymousResourceCollection;

    public function findById(int $id): ?Property;

    public function create(array $data): Property;

    public function update(Property $property, array $data): Property;

    public function delete(Property $property): bool;
}
