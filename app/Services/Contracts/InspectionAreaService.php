<?php

namespace App\Services\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Resources\InspectionAreaResource;
use App\Models\InspectionArea;

interface InspectionAreaService
{
    /**
     * List of inspection areas.
     *
     * @return \Illuminate\Http\JsonResponse|AnonymousResourceCollection|null
     */

    public function listInspectionAreas(): ?AnonymousResourceCollection;

    /**
     * List of inspection areas items.
     *
     * @return \Illuminate\Http\JsonResponse|AnonymousResourceCollection|null
     */

    public function listInspectionAreaItems(): ?AnonymousResourceCollection;

     /**
     * Add inspection area.
     *
     * @param array $data
     * @return \App\Models\InspectionArea
     */
    public function addInspectionArea(array $data): InspectionArea;

    /**
     * Show inspection area.
     *
     * @param int $id
     * @return \App\Resources\InspectionAreaResource
     */
    public function showInspectionArea(int $id): InspectionAreaResource;

    /**
     * Update inspection area.
     *
     * @param int $id
     * @param array $data
     * @return InspectionArea
     */
    public function updateInspectionArea(int $id, array $data): InspectionArea;

    /**
     * Delete inspection area.
     *
     * @param int $id
     * @return void
     */
    public function deleteInspectionArea(int $id): void;
}