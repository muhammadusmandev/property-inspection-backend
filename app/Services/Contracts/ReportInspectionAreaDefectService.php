<?php

namespace App\Services\Contracts;

use App\Models\ReportDefect;

interface ReportInspectionAreaDefectService
{
    /**
     * Add report inspection area defect.
     *
     * @param array $data
     * @return \App\Models\ReportDefect
     */
    public function addInspectionAreaDefect(array $data): ReportDefect;
}
