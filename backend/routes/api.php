<?php

use App\Http\Controllers\Api\PriorityController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tasks', TaskController::class);
Route::get('priorities', [PriorityController::class, 'index']);
Route::get('tags', [TagController::class, 'index']);
