<?php

namespace App\Services\Contracts;

use App\Models\Report;

interface GenerateReportService
{
    /**
     * Generate and save pdf report to storage.
     *
     * @param int $report_id
     * @return string $path
     */
    public function savePdfReport(int $report_id): string;

    /**
     * Get report data.
     *
     * @param int $report_id
     * @return Report $report
     */
    public function getReportData(int $report_id): Report;
}