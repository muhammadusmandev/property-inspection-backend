<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportInspectionArea;
use App\Models\ReportInspectionAreaItem;
use App\Models\Template;
use App\Resources\ReportResource;
use App\Services\Contracts\ReportService as ReportServiceContract;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportService implements ReportServiceContract
{
    // protected ReportRepository $reportRepository;

    // public function __construct(ReportRepository $reportRepository)
    // {
    //     $this->reportRepository = $reportRepository;
    // }

    public function listReports(): AnonymousResourceCollection
    {
        $columnQuery = request()->input('columnQuery');
        $columnName = request()->input('columnName');

        $query = Report::with(['property', 'template'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC');

        if ($columnName && $columnQuery) {
            if (str_contains($columnName, '.')) {      // search query on relation
                [$relation, $column] = explode('.', $columnName);

                $query->whereHas($relation, function ($q) use ($column, $columnQuery) {
                    $q->where($column, 'LIKE', "%{$columnQuery}%");
                });
            } else {
                $query->where($columnName, 'LIKE', "%{$columnQuery}%");
            }
        }

        // Todo: make trait/helper for getting boolean from request safely
        $paginate = filter_var(
            is_string($v = request()->input('paginate', true)) ? trim($v, "\"'") : $v,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        ) ?? true;

        if (!$paginate) {
            $reports = $query->get();
        } else {
            $reports = $query->paginate(request()->input('perPage') ?? 10);
        }

        return ReportResource::collection($reports);
    }

    public function createReport(array $data): Report
    {
        $data['user_id'] = auth()->id();
        $report = Report::create($data);
        if (!empty($data['template_id'])) {
            $template = Template::with('areas.items')->find($data['template_id']);

            if ($template && $template->areas->count()) {

                foreach ($template->areas as $index => $area) {

                    $reportInspectionArea = ReportInspectionArea::create([
                        'report_id' => $report->id,
                        'name' => $area->name,
                        'description' => $area->description,
                        'order' => $index
                    ]);

                    if ($area->items && $area->items->count()) {
                        foreach ($area->items as $index => $item) {
                            ReportInspectionAreaItem::create([
                                'report_inspection_area_id' => $reportInspectionArea->id,
                                'name' => $item->name,
                                'description' => $item->description,
                                'order' => $index

                            ]);
                        }
                    }
                }
            }
        }
        return $report;
    }

    public function deleteReport(int $id)
    {
        $report = Report::find($id);
        if (!$report) {
            throw new \Exception('Report not found.');
        }

        if ($report->user_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        $report->delete();

    }

    public function showReport(int $id): ReportResource
    {
        $report = Report::with(['areas.items'])->find($id);
        return new ReportResource($report);

    }

}

