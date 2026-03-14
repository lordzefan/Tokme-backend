<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ForgetPasswordController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/check-otp-register', [AuthenticationController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthenticationController::class, 'resendOtp']);
Route::post('/verify-register', [AuthenticationController::class, 'verifyRegister']);

Route::prefix('forgot-password')->group(function () {
    Route::post('/request', [ForgetPasswordController::class, 'request']);
    Route::post('/check-otp', [ForgetPasswordController::class, 'checkOtp']);
    Route::post('/resend-otp', [ForgetPasswordController::class, 'resendOtp']);
    Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword']);
});


Route::post('/login', [AuthenticationController::class, 'login']);