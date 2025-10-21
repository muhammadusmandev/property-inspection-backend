<?php

namespace App\Services\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Property;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface PropertyService
{
    /**
     * Get a paginated list of properties for the authenticated user.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listProperties(): AnonymousResourceCollection;

    /**
     * Create a new property for the logged-in user.
     *
     * @param array $data
     * @return \App\Models\Property
     */
    public function createProperty(array $data): Property;

    /**
     * Show property details by ID.
     *
     * @param int $id
     * @return \App\Models\Property
     */
    public function showProperty(int $id): Property;

    /**
     * Update property by ID.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Property
     */
    public function updateProperty(int $id, array $data): Property;

    /**
     * Delete property by ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteProperty(int $id): void;
}
