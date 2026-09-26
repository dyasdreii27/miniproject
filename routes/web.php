<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Dashboard Homepage Loader
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

// Form Actions Structural Endpoint Maps
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::patch('/tasks/{id}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
