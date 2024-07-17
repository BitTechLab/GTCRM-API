<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\CustomerController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('up', function () {
    return 'up';
}); //->where("any", ".*")->name('application');

// Route::prefix('auth')->group(function () {
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', RegisterController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);
});
// });

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('/customers', CustomerController::class); //->except('destroy');
});