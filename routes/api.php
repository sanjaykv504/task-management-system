<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum','log_execution_time'])->group(function () {
    Route::post('/tasks', [TaskController::class, 'storeTask']);
    Route::put('/tasks/{id}/assign', [TaskController::class, 'assignTask']);
    Route::put('/tasks/{id}/complete', [TaskController::class, 'completeTask']);
    Route::get('/tasks', [TaskController::class, 'showTasks']);
});

