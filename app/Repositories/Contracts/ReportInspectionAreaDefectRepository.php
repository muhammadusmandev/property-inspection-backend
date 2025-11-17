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
}
