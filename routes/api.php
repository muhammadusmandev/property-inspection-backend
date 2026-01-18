<?php

use App\Http\Controllers\Api\Branch\BranchController;
use App\Http\Controllers\Api\Client\ClientController;
use App\Http\Controllers\Api\Reports\ReportController;
use App\Http\Controllers\Api\Reports\ReportInspectionAreaController;
use App\Http\Controllers\Api\Reports\ReportInspectionAreaDefectController;
use App\Http\Controllers\Api\Reports\ReportContactController;
use App\Http\Controllers\Api\Template\TemplateController;
use App\Http\Controllers\Api\InspectionArea\InspectionAreaController;
use App\Http\Controllers\Api\InspectionArea\InspectionAreaItemController;
use App\Http\Controllers\Api\Media\MediaController;
use App\Http\Controllers\Api\Billing\BillingController;
use App\Http\Controllers\Api\Dashboard\DashboardController;
use App\Http\Controllers\Api\Settings\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\{
    AuthController,
    OtpVerificationController,
    ForgotPasswordController
};
use App\Http\Controllers\Api\Property\PropertyController;
use App\Http\Controllers\Api\Country\CountryController;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('register', [AuthController::class, 'register'])->name('auth.register');
        Route::delete('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
    });

    Route::prefix('otp')->group(function () {
        Route::post('verify', [OtpVerificationController::class, 'verify'])->name('auth.verify_otp');
        Route::post('resend', [OtpVerificationController::class, 'resend'])->name('auth.resend_otp');
    });

    Route::prefix('forgot-password')->group(function () {
        Route::post('/request', [ForgotPasswordController::class, 'request'])->name('forgot_password.request');
        Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('forgot_password.reset_password');
    });

    Route::get('countries/list', [CountryController::class, 'index'])->name('countries.list');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/user', function (Request $request) {
            return $request->user();
        });
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::apiResource('properties', PropertyController::class)->name('properties');
        Route::apiResource('branches', BranchController::class)->name('branches');
        Route::apiResource('clients', ClientController::class);
        Route::apiResource('templates', TemplateController::class);
        Route::apiResource('inspection-areas', InspectionAreaController::class);
        Route::apiResource('inspection-area-items', InspectionAreaItemController::class);
        Route::apiResource('report-inspection-areas', ReportInspectionAreaController::class);
        Route::apiResource('report-inspection-area-defects', ReportInspectionAreaDefectController::class);
        Route::apiResource('reports', ReportController::class);
        Route::apiResource('report-contacts', ReportContactController::class);
        Route::apiResource('medias', MediaController::class);
        Route::get('clients/properties/{id}', [ClientController::class, 'clientProperties']);
        Route::post('clients/associate-property', [ClientController::class, 'associateProperty']);
        Route::post('report-inspection-areas/upload-images', [ReportInspectionAreaController::class, 'storeImages']);
        Route::post('report-inspection-area-defects/{id}', [ReportInspectionAreaDefectController::class, 'updateDefect']);
        Route::put('update-report-inspection-checklist', [ReportController::class, 'updateCheckList']);
        Route::put('generate-report/{id}', [ReportController::class, 'generateReport']);
        Route::get('check-report-status/{id}', [ReportController::class, 'checkReportStatus']);
        Route::post('save-report-signature/{id}', [ReportController::class, 'saveReportSignature']);
        Route::get('list-report-contacts/{id}', [ReportContactController::class, 'index']);
        Route::get('billings/show-billing-data', [BillingController::class, 'showBillingData']);
        Route::post('billings/activate-subscription', [BillingController::class, 'activateSubscription']);
        Route::get('subscriptions/status', [BillingController::class, 'subscriptionStatus']);

        Route::prefix('settings')->group(function () {
            Route::get('/profile', [ProfileController::class, 'getProfile'])->name('settings.get_profile');
            Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('settings.update_profile');
            Route::delete('/delete-profile-photo', [ProfileController::class, 'deleteProfilePhoto']);
            Route::put('/reset-password', [ProfileController::class, 'resetPassword']);
        });
    });

});
