<?php

namespace App\Repositories;

use App\Repositories\Contracts\ReportInspectionAreaRepository as ReportInspectionAreaRepositoryContract;
use App\Models\ReportInspectionArea;
use App\Resources\ReportInspectionAreaResource;

class ReportInspectionAreaRepository implements ReportInspectionAreaRepositoryContract
{
    /**
     * List of report inspection areas
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection AnonymousResourceCollection
     */
    public function listReportInspectionAreas(): ?\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ReportInspectionAreaResource::collection(
            ReportInspectionArea::with('items')->latest()->get()
        );
    }

    /**
     * Add inspection area
     *
     * @param array $data
     * @return ReportInspectionArea
     */
    public function addReportInspectionArea(array $data): ReportInspectionArea
    {
        return ReportInspectionArea::create([
            'report_id' => $data['report_id'],
            'name' => $data['name'],
            'condition' => $data['condition'],
            'cleanliness' => $data['cleanliness'],
            'description' => $data['description'] ?? null,
            'realtor_id' => auth()->id(),
        ]);
    }

     /**
     * Find report inspection area.
     *
     * @param int $id
     * @return \App\Models\ReportInspectionArea $area
     */
    public function findById(int $id): ?ReportInspectionArea
    {
        return ReportInspectionArea::with('items')->find($id);
    }

    /**
     * Update inspection area.
     *
     * @param ReportInspectionArea $area
     * @param array $data
     * @return \App\Models\ReportInspectionArea $area
     */
    public function update(ReportInspectionArea $area, array $data): void
    {
        $area->update([
            'name' => $data['name'],
            'condition' => $data['condition'],
            'cleanliness' => $data['cleanliness'],
            'description' => $data['description'] ?? null,
        ]);
    }

    /**
     * Delete report inspection area.
     *
     * @param \App\Models\ReportInspectionArea $area
     * @return bool
     */
    public function delete(ReportInspectionArea $area): void
    {
        $area->delete();
    }
}
