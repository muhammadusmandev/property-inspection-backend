<?php

namespace App\Services;

use App\Models\Report;
use App\Repositories\Contracts\ReportRepository;
use App\Resources\CountryResource;
use App\Services\Contracts\ReportService as ReportServiceContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportService implements ReportServiceContract
{
    protected ReportRepository $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function listReports(): AnonymousResourceCollection{

    }

    public function createReport(array $data): Report
    {
        $report = Report::create($data);
        return $report;
    }
}

