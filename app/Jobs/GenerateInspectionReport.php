<?php

namespace App\Jobs;

use App\Services\Contracts\GenerateReportService as GenerateReportServiceContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Report;

class GenerateInspectionReport implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue, Dispatchable;

    public $report_id;
    protected GenerateReportServiceContract $generateReportService;

    /**
     * Create a new job instance.
     */
    public function __construct($report_id)
    {
        $this->report_id = $report_id;
    }

    /**
     * Execute the job.
     */
    public function handle(GenerateReportServiceContract $generateReportService): void
    {
        $pdfName = $generateReportService->savePdfReport($this->report_id);
        $downloadUrl = route('reports.download', ['file' => $pdfName]);
        Report::where('id', $this->report_id)->update([
            'download_link' => $downloadUrl,
            'locked_at' => now(),
            'status' => 'completed'
        ]);
    }
}
