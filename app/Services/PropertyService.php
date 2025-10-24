<?php

namespace App\Services;

use App\Models\Property;
use App\Repositories\Contracts\PropertyRepository;
use App\Services\Contracts\PropertyService as PropertyServiceContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PropertyService implements PropertyServiceContract
{
    protected PropertyRepository $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * Get all properties for the authenticated user.
     */
    public function listProperties(): AnonymousResourceCollection
    {
        return $this->propertyRepository->getAllForUser(Auth::id(), request()->perPage);
    }

    /**
     * Create a new property for the logged-in user.
     */
    public function createProperty(array $data): Property
    {
        $data['user_id'] = Auth::id();
        return $this->propertyRepository->create($data);
    }

    /**
     * Show a specific property.
     */
    public function showProperty(int $id): Property
    {
        $property = $this->propertyRepository->findById($id);

        if (!$property) {
            throw new \Exception('Property not found.');
        }

        if ($property->user_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return $property;
    }

    /**
     * Update property details.
     */
    public function updateProperty(int $id, array $data): Property
    {
        $property = $this->propertyRepository->findById($id);

        if (!$property) {
            throw new \Exception('Property not found.');
        }

        if ($property->user_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return $this->propertyRepository->update($property, $data);
    }

    /**
     * Delete property.
     */
    public function deleteProperty(int $id): void
    {
        $property = $this->propertyRepository->findById($id);

        if (!$property) {
            throw new \Exception('Property not found.');
        }

        if ($property->user_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        $this->propertyRepository->delete($property);
    }
}
