<?php

use App\Http\Controllers\Admin\ChangeRequestReviewController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TimeLogReviewController;
use App\Http\Controllers\Portal\ChangeRequestController;
use App\Http\Controllers\Portal\DashboardController;
use App\Http\Controllers\Portal\TimeLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route(auth()->user()->isClient() ? 'portal.dashboard' : 'admin.time-logs.index')
        : redirect()->route('login');
});

Route::middleware(['auth', 'verified', 'role:client'])
    ->prefix('portal')
    ->name('portal.')
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::resource('time-logs', TimeLogController::class)->only(['index', 'create', 'store']);
        Route::resource('change-requests', ChangeRequestController::class)->only(['index', 'create', 'store']);
    });

Route::middleware(['auth', 'verified', 'role:admin,staff'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/time-logs', [TimeLogReviewController::class, 'index'])->name('time-logs.index');
        Route::put('/time-logs/{timeLog}', [TimeLogReviewController::class, 'update'])->name('time-logs.update');

        Route::get('/change-requests', [ChangeRequestReviewController::class, 'index'])->name('change-requests.index');
        Route::put('/change-requests/{changeRequest}', [ChangeRequestReviewController::class, 'update'])->name('change-requests.update');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/csv', [ReportController::class, 'csv'])->name('reports.csv');
        Route::get('/reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
    });

Route::middleware(['auth', 'verified', 'role:admin,staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/time-logs', [TimeLogReviewController::class, 'index'])->name('time-logs.index');
        Route::put('/time-logs/{timeLog}', [TimeLogReviewController::class, 'update'])->name('time-logs.update');

        Route::get('/change-requests', [ChangeRequestReviewController::class, 'index'])->name('change-requests.index');
        Route::put('/change-requests/{changeRequest}', [ChangeRequestReviewController::class, 'update'])->name('change-requests.update');
    });

require __DIR__.'/auth.php';
