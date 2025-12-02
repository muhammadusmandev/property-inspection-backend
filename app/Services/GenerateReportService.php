<?php

namespace App\Services;

use App\Services\Contracts\GenerateReportService as GenerateReportServiceContract;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use App\Models\Report;

class GenerateReportService implements GenerateReportServiceContract
{
    // Todo: Need to handle exceptions and log if report find or save fail
    /**
     * Generate and save pdf report to storage.
     *
     * @param int $report_id
     * @return string $path
     */
    public function savePdfReport(int $report_id): string
    {
        $report = $this->getReportData($report_id);
        $reportsDirectory = storage_path('app/public/reports');

        if (!file_exists($reportsDirectory)) {
            mkdir($reportsDirectory, 0755, true);
        }

        $reportPdfName = "{$report->uuid}-". now()->format('Ymd_His') . ".pdf";

        $savePath = $reportsDirectory . DIRECTORY_SEPARATOR . $reportPdfName;

        Pdf::view('reports.report_v1', [
                'report' => $report
            ])
            ->headerHtml(view('reports.partials.header')->render())
            ->footerHtml(view('reports.partials.footer')->render())
            ->margins(15, 5, 20, 5)
            ->format('A4')
            ->withBrowsershot(function (Browsershot $shot) {
                $shot->setOption('printBackground', true);
            })
            ->save($savePath);

        return 'reports/' . $reportPdfName;
    }

    /**
     * Get report data.
     *
     * @param int $report_id
     * @return Report $report
     */
    public function getReportData(int $report_id): Report
    {
        $report = Report::select([
                    'id', 'uuid', 'property_id', 'template_id', 'user_id', 'title', 'type', 'report_date'
                ])
                ->with([
                    'areas' => function ($query) {
                        $query->latest()
                            ->select(['id', 'report_id', 'name', 'condition', 'cleanliness', 'description']);
                    },
                    'areas.items' => function ($query) {
                        $query->select(['id', 'report_inspection_area_id', 'name']);
                    },
                    'areas.media' => function ($query) {
                        $query->select(['id', 'mediable_id', 'file_path']);
                    },
                    'areas.defects' => function ($query) {
                        $query->select(['id', 'report_inspection_area_id', 'inspection_area_item_id', 'defect_type', 'remediation', 'priority', 'comments'])
                        ->with(['item:id,name']);
                    },
                    'areas.defects.media' => function ($query) {
                        $query->select(['id', 'mediable_id', 'file_path']);
                    },
                    'property' => function ($query) {
                        $query->select(['id', 'client_id', 'address', 'address_2', 'city', 'state', 'country', 'postal_code', 'type']);
                    },
                    'property.client' => function ($query) {
                        $query->select(['id', 'name', 'email', 'phone_number']);
                    },
                    'user' => function ($query) {
                        $query->select(['id', 'name', 'email', 'phone_number']);
                    }
                ])
                ->find($report_id);

        $report->checklist = $report->checklistItemsWithStatus();

        return $report;
    }
}
