<?php

namespace App\Repositories;

use App\Repositories\Contracts\ReportInspectionAreaDefectRepository as ReportInspectionAreaDefectRepositoryContract;
use App\Models\ReportDefect;

class ReportInspectionAreaDefectRepository implements ReportInspectionAreaDefectRepositoryContract
{
    /**
     * Add inspection area defect
     *
     * @param array $data
     * @return \App\Models\ReportDefect
     */
    public function addInspectionAreaDefect(array $data): ReportDefect
    {
        return ReportDefect::create([
            'report_inspection_area_id' => $data['inspection_area_id'],
            'inspection_area_item_id' => $data['defect_item_id'],
            'defect_type' => $data['defect_type'],
            'remediation' => $data['remediation'],
            'priority' => $data['priority'],
            'comments' => $data['comments'] ?? null,
        ]);
    }
}
