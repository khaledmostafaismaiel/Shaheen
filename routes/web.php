<?php

use Illuminate\Support\Facades\Route;

\Illuminate\Support\Facades\Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Http\Controllers\DashboardController::class);
    Route::get('/jiras/{jira}', \App\Http\Controllers\ShowJiraController::class);
    Route::get('/teams/{team}', \App\Http\Controllers\ShowTeamController::class);
    Route::get('/boards/{board}', \App\Http\Controllers\ShowBoardController::class);
    Route::put('/api/gantt-task/{jira}/task/{taskId}', \App\Http\Controllers\UpdateGanttTaskController::class);
    Route::post('/api/gantt-task/{jira}/link', \App\Http\Controllers\StoreGanttTaskLinkController::class);
    Route::delete('/api/gantt-task/{jira}/link/{linkId}', \App\Http\Controllers\DeleteGanttTaskLinkController::class);
    Route::post('/boards/{board}/issues/reset', \App\Http\Controllers\ResetBoardIssuesController::class);
});

Route::get('/boards/{board}/sprints/{sprintId}', \App\Http\Controllers\ShowSprintController::class);
Route::get('/api/boards/{board}/sprints/{sprintId}/issues', \App\Http\Controllers\ListSprintIssuesController::class);
