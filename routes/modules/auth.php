<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


/*
|--------------------------------------------------------------------------
| AUTH Routes
|--------------------------------------------------------------------------

*/
Route::get('/sanctum/csrf-cookie', [Laravel\Sanctum\Http\Controllers\CsrfCookieController::class, 'show']);
Route::post('resend-otp', [AuthController::class, 'resendOtp']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);