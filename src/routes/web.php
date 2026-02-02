<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login');
});

Route::controller(DashboardController::class)->group(function () {
   Route::get('/dashboard', 'index');
});
