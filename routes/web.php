<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/reset-password/{token}', function ($token) {
    return response()->json(['token' => $token]); // Todo: Need to implement reset password via reset link
})->name('password.reset');

Route::get('/generate-sample-report/{report_id}', [ReportController::class, 'downloadReportPDF']);

Route::get('/generate-sample-report-view/{report_id}', [ReportController::class, 'viewgenerateReport']);