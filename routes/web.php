<?php

use Illuminate\Support\Facades\Route;

\Illuminate\Support\Facades\Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Http\Controllers\DashboardController::class);
    Route::get('/jiras/{jira}', \App\Http\Controllers\ShowJiraController::class);
    Route::get('/teams/{team}', \App\Http\Controllers\ShowTeamController::class);
});

