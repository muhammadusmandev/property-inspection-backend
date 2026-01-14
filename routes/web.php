<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/reset-password/{token}', function ($token) {
    return response()->json(['token' => $token]); // Todo: Need to implement reset password via reset link
})->name('password.reset');

// Currently used by team to generate report 
// Todo: Implement restriction of team or move to admin panel etc.
Route::get('/generate-report/{report_id}', [ReportController::class, 'saveReportPDF'])->name('reports.generate'); 
Route::get('/generate-report-view/{report_id}', [ReportController::class, 'viewReport'])->name('reports.generate_view');
Route::get('/report-download/{file}', [ReportController::class, 'downloadReport'])->name('reports.download');
