<?php

use App\Lib\Route;
use App\Controllers\TaskController;
use App\Controllers\LoginController;
use App\Controllers\Admin\TaskController as AdminTaskController;

Route::get('/', [TaskController::class, 'index']);
Route::post('task', [TaskController::class, 'store']);

Route::get('login', [LoginController::class, 'index']);
Route::post('login', [LoginController::class, 'store']);
Route::post('logout', [LoginController::class, 'destroy']);

Route::get('admin', [AdminTaskController::class, 'index']);
Route::post('admin/update-task', [AdminTaskController::class, 'update']);
