<?php

namespace App\Services;

use App\Models\{ Report, ReportChecklistItem };
use App\Models\ReportInspectionArea;
use App\Models\ReportInspectionAreaItem;
use App\Models\Template;
use App\Resources\ReportResource;
use App\Services\Contracts\ReportService as ReportServiceContract;
use Auth;
use DB;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Storage;

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
        DB::beginTransaction();

        try {

            $data['user_id'] = auth()->id();
            $report = Report::create($data);

            if (!empty($data['template_id'])) {
                $template = Template::with('areas.items')->find($data['template_id']);

                if ($template && $template->areas->count()) {

                    foreach ($template->areas as $areaIndex => $area) {

                        $reportInspectionArea = ReportInspectionArea::create([
                            'report_id' => $report->id,
                            'name' => $area->name,
                            'description' => $area->description,
                            'order' => $areaIndex
                        ]);

                        if ($area->items && $area->items->count()) {
                            foreach ($area->items as $itemIndex => $item) {
                                ReportInspectionAreaItem::create([
                                    'report_inspection_area_id' => $reportInspectionArea->id,
                                    'name' => $item->name,
                                    'description' => $item->description,
                                    'order' => $itemIndex
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();
            return $report;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
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
        $report = Report::with([
            'areas' => function ($query) {
                $query->latest();
            },
            'areas.items'
        ])->find($id);
        return new ReportResource($report);

    }

    public function updateReport(int $id, array $data): Report
    {
        DB::beginTransaction();

        try {
            $report = Report::find($id);
            $report->update([
                "title" => $data['title'],
                "property_id" => $data['property_id'],
                "template_id" => $data['template_id'],
                "type" => $data['type'],
                "report_date" => $data['report_date']
            ]);
            $areaIds = [];

            foreach ($data['areas'] as $areaKey => $areaData) {

                $area = $report->areas()->updateOrCreate(
                    ['id' => $areaData['id'] ?? null],
                    [
                        'name' => $areaData['name'],
                        'condition' => $areaData['condition'] ?? null,
                        'cleanliness' => $areaData['cleanliness'] ?? null,
                        'description' => $areaData['description'] ?? null,
                        'order' => $areaKey ?? null,
                    ]
                );

                $areaIds[] = $area->id;

                if (request()->hasFile("areas.$areaKey.media")) {
                    $this->saveMedia($area, request()->file("areas.$areaKey.media"));
                }

                $itemIds = [];
                foreach ($areaData['items'] as $itemKey => $itemData) {

                    $item = $area->items()->updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                        [
                            'name' => $itemData['name'],
                            'description' => $itemData['description'] ?? null,
                            'condition' => $itemData['condition'] ?? null,
                            'cleanliness' => $itemData['cleanliness'] ?? null,
                            'order' => $itemKey ?? null,
                        ]
                    );

                    $itemIds[] = $item->id;

                    if (request()->hasFile("areas.$itemKey.items.$itemKey.media")) {
                        $this->saveMedia($item, request()->file("areas.$itemKey.items.$itemKey.media"));
                    }
                }

                $area->items()->whereNotIn('id', $itemIds)->delete();

                $defectIds = [];
                foreach ($areaData['areaDefects'] ?? [] as $defectKey => $defectData) {

                    $defect = $area->defects()->updateOrCreate(
                        ['id' => $defectData['id'] ?? null],
                        [
                            'category' => $defectData['category'],
                            'description' => $defectData['description'] ?? null,
                        ]
                    );

                    $defectIds[] = $defect->id;

                    if (request()->hasFile("areas.$defectKey.defects.$defectKey.media")) {
                        $this->saveMedia($defect, request()->file("areas.$defectKey.defects.$defectKey.media"));
                    }
                }
                $area->defects()->whereNotIn('id', $defectIds)->delete();
            }
            $report->areas()->whereNotIn('id', $areaIds)->delete();



            DB::commit();
            return $report;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function saveMedia($model, $files)
    {
        if (!$files)
            return;

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                if (!Storage::disk('public')->exists('reports')) {
                    Storage::disk('public')->makeDirectory('reports');
                }
                $path = $file->store('reports', 'public');

                $model->media()->create([
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                ]);
            }
        }
    }

    /**
     * Update report inspection checklist item.
     * @param array $data
     */
    public function updateReportChecklist(array $data)
    {
        $report = Report::find($data['report_id']);

        if (!$report) {
            throw new \Exception('Report not found.');
        }

        if ($report->user_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        ReportChecklistItem::updateOrCreate(
            [
                'report_id' => $data['report_id'],
                'inspection_checklist_id' => $data['checklist_id'],
            ],
            [
                'checked' => $data['checked'],
            ]
        );
    }

    /**
     * Mark report lock
     * @param int $id
     */
    public function markReportLocked(int $id): void
    {
        $report = Report::find($id);

        if (!$report) {
            throw new \Exception('Report not found.');
        }

        if ($report->user_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        $report->locked_at = now();
        $report->update();
    }
}

