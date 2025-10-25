<?php

namespace App\Repositories;

use App\Models\Property;
use App\Repositories\Contracts\PropertyRepository as PropertyRepositoryContract;
use App\Resources\PropertyResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PropertyRepository implements PropertyRepositoryContract
{
    public function getAllForUser(int $userId, int $perPage = 10): AnonymousResourceCollection
    {
        $columnQuery = request()->input('columnQuery');
        $columnName = request()->input('columnName');

        $query = Property::with('branch', 'rooms','client')
            ->where('user_id', $userId)
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

        $properties = $query->paginate(request()->input('perPage') ?? $perPage);

        return PropertyResource::collection($properties);
    }

    public function findById(int $id): ?Property
    {
        return Property::with('branch', 'rooms','client')->find($id);
    }

    public function create(array $data): Property
    {
        return Property::create($data);
    }

    public function update(Property $property, array $data): Property
    {
        $property->update($data);
        return $property;
    }

    public function delete(Property $property): bool
    {
        return $property->delete();
    }
}
