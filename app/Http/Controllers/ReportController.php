<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use App\Models\Report;

class ReportController extends Controller
{
    public function downloadReportPDF($report_id)
    {
        $report = Report::select([
                    'id', 'property_id', 'template_id', 'user_id', 'title', 'type', 'report_date'
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
                ])
                ->find($report_id);

        $report->checklist = $report->checklistItemsWithStatus();

        return Pdf::view('reports.report_v1', [
                'report' => $report
            ])
            ->headerHtml(view('reports.partials.header')->render())
            ->margins(15, 5, 0, 5)
            ->format('A4')
            ->withBrowsershot(function (Browsershot $shot) {
                $shot->setOption('printBackground', true);
            })
            ->download('inspection.pdf');
    }

    public function viewgenerateReport($report_id)
    {
        $report = Report::select([
                    'id', 'property_id', 'template_id', 'user_id', 'title', 'type', 'report_date'
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
                    'property' => function ($query) {
                        $query->select(['id', 'client_id', 'address', 'address_2', 'city', 'state', 'country', 'postal_code', 'type']);
                    },
                    'property.client' => function ($query) {
                        $query->select(['id', 'name', 'email', 'phone_number']);
                    },
                    'user' => function ($query) {
                        $query->select(['id', 'name', 'email', 'phone_number']);
                    },
                ])
                ->find($report_id);

        $report->checklist = $report->checklistItemsWithStatus();

        return view('reports.report_v1', ['report' => $report]);
    }
}
