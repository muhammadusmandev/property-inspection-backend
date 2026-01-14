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
    public function showReport(int|string $id): ReportResource;
    public function updateReport(int $id, array $data): Report;
    // public function saveMedia($model, $files);
    public function updateReportChecklist(array $data);
    public function generateReport(int $id): Report;
    public function checkReportStatus(int $id): array;
    public function saveReportSignature(string $id, $data): void;
}
