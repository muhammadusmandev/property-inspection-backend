<?php

namespace App\Services;

use App\Services\Contracts\InspectionAreaService as InspectionAreaServiceContract;
use App\Repositories\Contracts\InspectionAreaRepository as InspectionAreaRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\{ InspectionArea, InspectionAreaItemPivot };
use App\Resources\InspectionAreaResource;
use DB;

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

    /**
     * Show inspection area.
     *
     * @param int $id
     * @return \App\Resources\InspectionAreaResource
     */
    public function showInspectionArea(int $id): InspectionAreaResource
    {
        $area = $this->inspectionAreaRepository->findById($id);
        if (!$area) {
            throw new \Exception('Area not found.');
        }
        return new InspectionAreaResource($area);
    }

    /**
     * Update inspection area.
     *
     * @param int $id
     * @param array $data
     * @return InspectionArea
     */
    public function updateInspectionArea(int $id, array $data): InspectionArea
    {
        $area = $this->inspectionAreaRepository->findById($id);
        if (!$area) {
            throw new \Exception('Area not found.');
        }

        if ($area->inspector_id !== auth()->id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return DB::transaction(function () use ($area, $data) {
            $this->inspectionAreaRepository->update($area, $data);
            
            $area->items()->sync($data['items']);

            return $area;
        });
    }

    /**
     * Delete inspection area.
     *
     * @param int $id
     * @return void
     */
    public function deleteInspectionArea(int $id): void
    {
        $area = $this->inspectionAreaRepository->findById($id);
        if (!$area) {
            throw new \Exception('Inspection area not found.');
        }

        if ($area->inspector_id !== auth()->id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        /** 
         * Todo: uncomment when templates relationship added
         * $hasTemplates = $area->whereHas('template')->exists();
         *  if ($hasTemplates) {
         *     throw new \Exception("Action forbidden. One or more templates using same areas.");
         *  }
         **/

        $this->inspectionAreaRepository->delete($area);
    }
}
