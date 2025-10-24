<?php

use App\Http\Controllers\Api\Branch\BranchController;
use App\Http\Controllers\Api\Client\ClientController;
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
        Route::apiResource('properties', PropertyController::class);
        Route::apiResource('branches', BranchController::class);
        Route::apiResource('clients', ClientController::class);
    });

});
