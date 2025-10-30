<?php

namespace App\Services;

use App\Services\Contracts\InspectionAreaService as InspectionAreaServiceContract;
use App\Repositories\Contracts\InspectionAreaRepository as InspectionAreaRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\InspectionArea;

class InspectionAreaService implements InspectionAreaServiceContract
{
    protected $inspectionAreaRepository;

    /**
     * Inject InspectionAreaRepository via constructor.
     * @param \App\Repositories\Contracts\InspectionAreaRepository $inspectionAreaRepository
    */
    public function __construct(InspectionAreaRepositoryContract $inspectionAreaRepository)
    {
        $this->inspectionAreaRepository = $inspectionAreaRepository;
    }

    /**
     * List of inspection areas.
     *
     * @return \Illuminate\Http\JsonResponse|AnonymousResourceCollection|null
     */

    public function listInspectionAreas(): ?AnonymousResourceCollection
    {
        return $this->inspectionAreaRepository->listInspectionAreas();
    }

    /**
     * List of inspection areas items.
     *
     * @return \Illuminate\Http\JsonResponse|AnonymousResourceCollection|null
     */

    public function listInspectionAreaItems(): ?AnonymousResourceCollection
    {
        return $this->inspectionAreaRepository->listInspectionAreaItems();
    }

     /**
     * Add inspection area.
     *
     * @param array $data
     * @return \App\Models\InspectionArea
     */

    public function addInspectionArea(array $data): InspectionArea
    {
        return $this->inspectionAreaRepository->addInspectionArea($data);
    }
}
