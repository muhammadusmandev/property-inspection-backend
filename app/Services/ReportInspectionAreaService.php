<?php

namespace App\Services;

use App\Services\Contracts\ReportInspectionAreaService as ReportInspectionAreaServiceContract;
use App\Repositories\Contracts\ReportInspectionAreaRepository as ReportInspectionAreaRepositoryContract;
use App\Resources\ReportInspectionAreaResource;
use App\Models\ReportInspectionArea;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Auth\Access\AuthorizationException;
use DB;

/**
 * Business logic layer for handling Report Inspection Area operations.
 */
class ReportInspectionAreaService implements ReportInspectionAreaServiceContract
{
    protected ReportInspectionAreaRepositoryContract $reportInspectionAreaRepository;

    public function __construct(ReportInspectionAreaRepositoryContract $reportInspectionAreaRepository)
    {
        $this->reportInspectionAreaRepository = $reportInspectionAreaRepository;
    }

    /**
     * List of report inspection areas.
     *
     * @return \Illuminate\Http\JsonResponse|AnonymousResourceCollection|null
     */
    public function listReportInspectionAreas(): ?AnonymousResourceCollection
    {
        return $this->reportInspectionAreaRepository->listReportInspectionAreas();
    }

    /**
     * Add report inspection area.
     *
     * @param array $data
     * @return \App\Models\InspectionArea
     */
    public function addReportInspectionArea(array $data): ReportInspectionArea
    {
        return DB::transaction(function () use ($data) {
            $area = $this->reportInspectionAreaRepository->addReportInspectionArea($data);
            if (!empty($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $area->items()->create([
                        'name' => $item
                    ]);
                }
            }

            return $area->load('items');
        });
    }

    /**
     * Show report inspection area.
     *
     * @param int $id
     * @return \App\Resources\InspectionAreaResource
     */
    public function showReportInspectionArea(int $id): ReportInspectionAreaResource
    {
        $area = $this->reportInspectionAreaRepository->findById($id);
        if (!$area) {
            throw new \Exception('Report inspection area not found.');
        }
        return new ReportInspectionAreaResource($area);
    }

    /**
     * Update report inspection area.
     *
     * @param int $id
     * @param array $data
     * @return InspectionArea
     */
    public function updateReportInspectionArea(int $id, array $data): ReportInspectionArea
    {
        $area = $this->reportInspectionAreaRepository->findById($id);
        if (!$area) {
            throw new \Exception('Report inspection area not found.');
        }

        if ($area->report->user_id !== auth()->id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return DB::transaction(function () use ($area, $data) {
            $this->reportInspectionAreaRepository->update($area, $data);
            $area->items()->delete();

            if (!empty($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $area->items()->create([
                        'name' => $item
                    ]);
                }
            }

            return $area->load('items');
        });
    }

    /**
     * Delete report inspection area.
     *
     * @param int $id
     * @return void
     */
    public function deleteReportInspectionArea(int $id): void
    {
        $area = $this->reportInspectionAreaRepository->findById($id);
        if (!$area) {
            throw new \Exception('Report inspection area not found.');
        }

        if ($area->report->user_id !== auth()->id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        $this->reportInspectionAreaRepository->delete($area);
    }
}
