<?php

use App\Http\Controllers\Api\Branch\BranchController;
use App\Http\Controllers\Api\Client\ClientController;
use App\Http\Controllers\Api\Reports\ReportController;
use App\Http\Controllers\Api\Reports\ReportInspectionAreaController;
use App\Http\Controllers\Api\Reports\ReportInspectionAreaDefectController;
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
        Route::post('login', [AuthController::class, 'login'])->middleware('throttle:login');
        Route::post('register', [AuthController::class, 'register'])->middleware('throttle:register');
        Route::delete('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::prefix('otp')->group(function () {
        Route::post('verify', [OtpVerificationController::class, 'verify'])->middleware('throttle:verify-otp');
        Route::post('resend', [OtpVerificationController::class, 'resend'])->middleware('throttle:send-otp');
    });

    Route::prefix('forgot-password')->group(function () {
        Route::post('/request', [ForgotPasswordController::class, 'request'])->middleware('throttle:request-otp');
        Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->middleware('throttle:reset-password');
    });

    Route::get('countries/list', [CountryController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/user', function (Request $request) {
            return $request->user();
        });
        Route::get('dashboard', [DashboardController::class, 'index']);
        Route::apiResource('properties', PropertyController::class);
        Route::apiResource('branches', BranchController::class);
        Route::apiResource('clients', ClientController::class);
        Route::apiResource('templates', TemplateController::class);
        Route::apiResource('inspection-areas', InspectionAreaController::class);
        Route::apiResource('inspection-area-items', InspectionAreaItemController::class);
        Route::apiResource('report-inspection-areas', ReportInspectionAreaController::class);
        Route::apiResource('report-inspection-area-defects', ReportInspectionAreaDefectController::class);
        Route::apiResource('reports', ReportController::class);
        Route::apiResource('medias', MediaController::class);
        Route::get('clients/properties/{id}', [ClientController::class, 'clientProperties']);
        Route::post('clients/associate-property', [ClientController::class, 'associateProperty']);
        Route::post('report-inspection-areas/upload-images', [ReportInspectionAreaController::class, 'storeImages']);
        Route::post('report-inspection-area-defects/{id}', [ReportInspectionAreaDefectController::class, 'updateDefect']);
        Route::put('update-report-inspection-checklist', [ReportController::class, 'updateCheckList']);
        Route::put('generate-report/{id}', [ReportController::class, 'generateReport']);
        Route::get('check-report-status/{id}', [ReportController::class, 'checkReportStatus']);
        Route::get('billings/show-billing-data', [BillingController::class, 'showBillingData']);
        Route::post('billings/activate-subscription', [BillingController::class, 'activateSubscription']);
        Route::get('subscriptions/status', [BillingController::class, 'subscriptionStatus']);

        Route::prefix('settings')->group(function () {
            Route::get('/profile', [ProfileController::class, 'getProfile']);
            Route::post('/update-profile', [ProfileController::class, 'updateProfile']);
            Route::delete('/delete-profile-photo', [ProfileController::class, 'deleteProfilePhoto']);
            Route::put('/reset-password', [ProfileController::class, 'resetPassword']);
        });
    });

});
