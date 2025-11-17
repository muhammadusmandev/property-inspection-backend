<?php

namespace App\Services\Contracts;

use App\Models\ReportDefect;
use App\Resources\InspectionAreaDefectResource;

interface ReportInspectionAreaDefectService
{
    /**
     * Add report inspection area defect.
     *
     * @param array $data
     * @return \App\Models\ReportDefect
     */
    public function addInspectionAreaDefect(array $data): ReportDefect;

    /**
     * Show report inspection area defect.
     *
     * @param int $id
     * @return \App\Resources\InspectionAreaDefectResource
     */
    public function showInspectionAreaDefect(int $id): InspectionAreaDefectResource;

    /**
     * Update report inspection area defect.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\ReportDefect
     */
    public function updateInspectionAreaDefect(int $id, array $data): ReportDefect;

    /**
     * Delete report inspection area defect.
     *
     * @param int $id
     * @return void
     */
    public function deleteInspectionAreaDefect(int $id): void;
}
