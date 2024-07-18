<?php

use Illuminate\Support\Facades\Route;

\Illuminate\Support\Facades\Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Http\Controllers\DashboardController::class);
});

