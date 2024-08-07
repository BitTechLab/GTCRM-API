<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', RegisterController::class)->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth', [AuthController::class, 'index'])->name('auth');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('v1')->group(base_path('routes/v1.php'));
// Route::prefix('v2')->group(base_path('routes/v2.php'));
