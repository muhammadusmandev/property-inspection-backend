<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\InspectionArea;

interface InspectionAreaRepository
{
    /**
     * List of inspection areas
     *
     * @param \Illuminate\Http\Resources\Json\AnonymousResourceCollection AnonymousResourceCollection
     * @return void
     */
    public function listInspectionAreas(): AnonymousResourceCollection;

    /**
     * List of inspection areas items
     *
     * @param \Illuminate\Http\Resources\Json\AnonymousResourceCollection AnonymousResourceCollection
     * @return void
     */
    public function listInspectionAreaItems(): AnonymousResourceCollection;

     /**
     * Add inspection area.
     *
     * @param array $data
     * @return \App\Models\InspectionArea
     */

    public function addInspectionArea(array $data): InspectionArea;
}
