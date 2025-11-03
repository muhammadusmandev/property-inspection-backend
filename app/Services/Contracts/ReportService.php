<?php

namespace App\Services\Contracts;

use App\Models\Report;
use App\Resources\ReportResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface ReportService
{
    public function listReports(): AnonymousResourceCollection;
    public function createReport(array $data): Report;
    public function deleteReport(int $id);
    public function showReport(int $id): ReportResource;
}
