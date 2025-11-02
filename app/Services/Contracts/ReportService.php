<?php

namespace App\Services\Contracts;

use App\Models\Report;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface ReportService
{
    public function listReports(): AnonymousResourceCollection;

    public function createReport(array $data): Report;
}
