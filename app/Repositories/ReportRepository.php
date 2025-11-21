<?php

namespace App\Repositories;

use App\Models\Report;
use App\Repositories\Contracts\ReportRepository as ReportRepositoryContract;
use App\Resources\ReportResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportRepository implements ReportRepositoryContract
{
    public function getAll(): AnonymousResourceCollection
    {
        $reporties = Report::where('status',1)->get();
        return ReportResource::collection($reporties);
    }


}
