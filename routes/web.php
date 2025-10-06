<?php

use Illuminate\Support\Facades\Route;

Route::get('/reset-password/{token}', function ($token) {
    return response()->json(['token' => $token]); // Todo: Need to implement reset password via reset link
})->name('password.reset');
