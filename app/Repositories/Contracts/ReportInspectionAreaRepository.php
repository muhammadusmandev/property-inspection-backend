<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\ReportInspectionArea;

interface ReportInspectionAreaRepository
{
    public function listReportInspectionAreas(): ?AnonymousResourceCollection;
    public function addReportInspectionArea(array $data): ReportInspectionArea;
    public function findById(int $id): ?ReportInspectionArea;
    public function update(ReportInspectionArea $area, array $data): void;
    public function delete(ReportInspectionArea $area): void;
}
