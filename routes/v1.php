<?php

use App\Http\Controllers\V1\LeadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\CustomerController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('leads', LeadController::class);
});