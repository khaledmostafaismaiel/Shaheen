<?php

use Illuminate\Support\Facades\Route;

\Illuminate\Support\Facades\Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Http\Controllers\DashboardController::class);
    Route::get('/jiras/{jira}', \App\Http\Controllers\ShowJiraController::class);
    Route::get('/teams/{team}', \App\Http\Controllers\ShowTeamController::class);
    Route::get('/boards/{board}', \App\Http\Controllers\ShowBoardController::class);
});

Route::get('/boards/{board}/sprints/{sprintId}', \App\Http\Controllers\ShowSprintController::class);
Route::get('/api/boards/{board}/sprints/{sprintId}/issues', \App\Http\Controllers\ListSprintIssuesController::class);
