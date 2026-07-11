<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RejectedReportController;
use App\Http\Controllers\ArsipReportController;
use App\Http\Controllers\AuditTrailController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Routes yang membutuhkan login
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Rejected Report — Admin & Supervisor QC bisa create/edit/delete
    Route::middleware(['role:Admin,Supervisor QC'])->group(function () {
        Route::get('/rejected-reports/create', [RejectedReportController::class, 'create'])
            ->name('rejected-reports.create');
        Route::post('/rejected-reports', [RejectedReportController::class, 'store'])
            ->name('rejected-reports.store');
        Route::get('/rejected-reports/{uuid}/edit', [RejectedReportController::class, 'edit'])
            ->name('rejected-reports.edit');
        Route::put('/rejected-reports/{uuid}', [RejectedReportController::class, 'update'])
            ->name('rejected-reports.update');
        Route::delete('/rejected-reports/{uuid}', [RejectedReportController::class, 'destroy'])
            ->name('rejected-reports.destroy');
    });

    // Rejected Report — semua user yang login bisa akses index & details & sign
    Route::get('/rejected-reports', [RejectedReportController::class, 'index'])
        ->name('rejected-reports.index');
    Route::get('/rejected-reports/{uuid}', [RejectedReportController::class, 'show'])
        ->name('rejected-reports.show');
    Route::post('/rejected-reports/{uuid}/sign', [RejectedReportController::class, 'sign'])
        ->name('rejected-reports.sign');

    // Arsip Report — semua user yang login bisa akses
    Route::get('/arsip-reports', [ArsipReportController::class, 'index'])
        ->name('arsip-reports.index');
    Route::get('/arsip-reports/{uuid}', [ArsipReportController::class, 'show'])
        ->name('arsip-reports.show');
    Route::get('/arsip-reports/{uuid}/download', [ArsipReportController::class, 'download'])
        ->name('arsip-reports.download');

    // Management User — hanya Admin
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create');
        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store');
        Route::get('/users/{uuid}/edit', [UserController::class, 'edit'])
            ->name('users.edit');
        Route::put('/users/{uuid}', [UserController::class, 'update'])
            ->name('users.update');
        Route::delete('/users/{uuid}', [UserController::class, 'destroy'])
            ->name('users.destroy');
    });

    // Audit Trail — hanya Admin
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/audit-trail', [AuditTrailController::class, 'index'])
            ->name('audit-trail.index');
    });
});

require __DIR__.'/auth.php';
