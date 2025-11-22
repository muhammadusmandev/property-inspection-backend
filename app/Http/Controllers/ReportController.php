<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Contracts\GenerateReportService as GenerateReportServiceContract;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use App\Jobs\GenerateInspectionReport;
use App\Models\Report;
use Storage;

class ReportController extends Controller
{
    protected GenerateReportServiceContract $generateReportService;

    /**
     * Inject GenerateReportServiceContract.
     */
    public function __construct(GenerateReportServiceContract $generateReportService)
    {
        $this->generateReportService = $generateReportService;
    }

    /**
     * Download report pdf.
     * 
     * @param int $report_id
     * 
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public function saveReportPDF($report_id)
    {
        $pdfName = $this->generateReportService->savePdfReport($report_id);
        $downloadUrl = route('reports.download', ['file' => $pdfName]);
        Report::where('id', $report_id)->update(['download_link' => $downloadUrl]);
        echo "Pdf saved successfully: " . $downloadUrl;
    }

    /**
     * View report pdf.
     * 
     * @param int $report_id
     * 
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public function viewReport($report_id)
    {
        $report = $this->generateReportService->getReportData($report_id);

        return view('reports.report_v1', ['report' => $report]);
    }

    public function downloadReport($file)
    {
        $path = 'reports/' . $file;

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->download(storage_path('app/public/' . $path));
    }
}
