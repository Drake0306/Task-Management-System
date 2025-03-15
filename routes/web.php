<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    // List all tasks
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');

    // Show create task form
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

    // Handle new task creation
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

    // Show edit task form
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

    // Update an existing task
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

    // Delete a task
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Mark a task as completed
    Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
