<?php

namespace App\Services\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
}