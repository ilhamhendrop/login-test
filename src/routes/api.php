<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'login');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(LoginController::class)->group(function () {
       Route::post('/logout', 'logout');
    });

    Route::controller(DashboardController::class)->group(function () {
       Route::get('/dashboard-data', 'dashboardData');
    });
});
