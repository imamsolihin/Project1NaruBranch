<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

// Select Division Routes (Protected by auth and role:user, but NOT has.division)
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/select-division', [\App\Http\Controllers\User\DivisionSelectionController::class, 'create'])->name('division.select');
    Route::post('/select-division', [\App\Http\Controllers\User\DivisionSelectionController::class, 'store'])->name('division.store');
});

// Dashboard Route (Protected by has.division)
Route::get('/dashboard', [\App\Http\Controllers\User\ProjectController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:user', 'has.division'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔥 ADMIN AREA
Route::middleware(['auth', 'role:super_admin,wakil_admin,admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('divisions', \App\Http\Controllers\Admin\DivisionController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    // Monitor all projects
    Route::get('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [\App\Http\Controllers\Admin\ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [\App\Http\Controllers\Admin\ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('projects.destroy');

    // Histories
    Route::get('/histories/users', [\App\Http\Controllers\Admin\HistoryController::class, 'users'])->name('histories.users');
    Route::get('/histories/projects', [\App\Http\Controllers\Admin\HistoryController::class, 'projects'])->name('histories.projects');
});

// 🧑‍💻 USER AREA
Route::middleware(['auth', 'role:user', 'has.division'])->group(function () {
    Route::resource('projects', \App\Http\Controllers\User\ProjectController::class);
});

require __DIR__.'/auth.php';