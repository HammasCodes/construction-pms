<?php

use App\Http\Controllers\BoqItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressTaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Projects
    Route::resource('projects', ProjectController::class);

    // Reports hub
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    // Project report (PDF export)
    Route::get('projects/{project}/report-pdf', [ReportController::class, 'pdf'])->name('projects.report.pdf');
    Route::get('projects/{project}/report-view', [ReportController::class, 'view'])->name('projects.report.view');

    // Nested resources under a project
    Route::resource('projects.boq', BoqItemController::class)->parameters(['boq' => 'boq'])->shallow(false);
    Route::resource('projects.expenses', ExpenseController::class)->parameters(['expenses' => 'expense'])->shallow(false);
    Route::resource('projects.progress', ProgressTaskController::class)->parameters(['progress' => 'progress'])->shallow(false);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
