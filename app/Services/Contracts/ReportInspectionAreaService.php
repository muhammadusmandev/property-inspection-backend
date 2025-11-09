<?php

namespace App\Services\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Resources\ReportInspectionAreaResource;
use App\Models\ReportInspectionArea;

interface ReportInspectionAreaService
{
    /**
     * List of report inspection areas.
     *
     * @return \Illuminate\Http\JsonResponse|AnonymousResourceCollection|null
     */
    public function listReportInspectionAreas(): ?AnonymousResourceCollection;

    /**
     * Add report inspection area.
     *
     * @param array $data
     * @return \App\Models\InspectionArea
     */
    public function addReportInspectionArea(array $data): ReportInspectionArea;

    /**
     * Show report inspection area.
     *
     * @param int $id
     * @return \App\Resources\InspectionAreaResource
     */
    public function showReportInspectionArea(int $id): ReportInspectionAreaResource;

    /**
     * Update report inspection area.
     *
     * @param int $id
     * @param array $data
     * @return InspectionArea
     */
    public function updateReportInspectionArea(int $id, array $data): ReportInspectionArea;

    /**
     * Delete report inspection area.
     *
     * @param int $id
     * @return void
     */
    public function deleteReportInspectionArea(int $id): void;
}
