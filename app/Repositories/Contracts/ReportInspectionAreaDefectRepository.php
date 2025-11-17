<?php

namespace App\Repositories\Contracts;

use App\Models\ReportDefect;

interface ReportInspectionAreaDefectRepository
{
    /**
     * Add inspection area defect
     *
     * @param array $data
     * @return \App\Models\ReportDefect
     */
    public function addInspectionAreaDefect(array $data): ReportDefect;

    /**
     * Find report inspection area defect.
     *
     * @param int $id
     * @return \App\Models\ReportDefect
     */
    public function findById(int $id): ReportDefect;

    /**
     * Delete report inspection area defect.
     *
     * @param \App\Models\ReportDefect $defect
     * @return bool
     */
    public function delete(ReportDefect $defect): void;
}
