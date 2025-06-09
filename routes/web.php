<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\SubcriteriaController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Artisan;

// Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Protected Routes - Require Admin Access (Admin can access alternatives, evaluations, reports)
Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Alternatives Routes (Admin access)
    Route::resource('alternatives', AlternativeController::class);
    Route::get('/alternatives/{alternative}/parameters', [AlternativeController::class, 'parameters'])->name('alternatives.parameters');
    Route::post('/alternatives/{alternative}/parameters', [AlternativeController::class, 'storeParameters'])->name('alternatives.parameters.store');
    Route::get('/alternatives/{alternative}/get-parameters', [AlternativeController::class, 'getParameters'])->name('alternatives.get.parameters');

    // Evaluation Routes (Admin access)
    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
    Route::get('/evaluations/create', [EvaluationController::class, 'create'])->name('evaluations.create');
    Route::post('/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/evaluations/bulk', [EvaluationController::class, 'bulkEvaluate'])->name('evaluations.bulk');
    Route::post('/evaluations/bulk', [EvaluationController::class, 'bulkStore'])->name('evaluations.bulk.store');
    Route::get('/evaluations/calculate', [EvaluationController::class, 'calculate'])->name('evaluations.calculate');
    Route::get('/evaluations/results', [EvaluationController::class, 'results'])->name('evaluations.results');

    // Reports routes (Admin access)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/{id}', [ReportController::class, 'show'])->name('show');
        Route::post('/', [ReportController::class, 'store'])->name('store');
        Route::delete('/{id}', [ReportController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/export', [ReportController::class, 'export'])->name('export');
    });
});

// Super Admin Only Routes (Full access including criteria and subcriteria management)
Route::middleware(['auth', 'superadmin'])->group(function () {
    // User Management Routes (SuperAdmin only)
    Route::resource('users', App\Http\Controllers\UserController::class);

    // Criteria Routes (SuperAdmin only)
    Route::resource('criteria', CriteriaController::class)->parameters([
        'criteria' => 'criteria'
    ]);
    Route::get('/criteria/comparison/pairwise', [CriteriaController::class, 'pairwiseComparison'])->name('criteria.pairwise');
    Route::post('/criteria/comparison/pairwise', [CriteriaController::class, 'storePairwiseComparison'])->name('criteria.pairwise.store');

    // Subcriteria Routes (SuperAdmin only)
    Route::resource('subcriteria', SubcriteriaController::class)->parameters([
        'subcriteria' => 'subcriteria'
    ]);
    Route::get('/subcriteria/{criteria}/comparison/pairwise', [SubcriteriaController::class, 'pairwiseComparison'])->name('subcriteria.pairwise');
    Route::post('/subcriteria/{criteria}/comparison/pairwise', [SubcriteriaController::class, 'storePairwiseComparison'])->name('subcriteria.pairwise.store');

    // Development route for seeding (SuperAdmin only)
    Route::get('/seed-data', function() {
        Artisan::call('db:seed');
        return redirect()->route('dashboard')->with('success', 'Data berhasil di-seed!');
    })->name('seed.data');
});
