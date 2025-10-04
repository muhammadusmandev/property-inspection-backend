<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

Route::prefix('v1')->group(function () {
    
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::delete('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::get('/auth/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

});
