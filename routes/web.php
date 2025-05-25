<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Super Admin Routes
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    
    // Criteria Management
    Route::get('/criteria', [SuperAdminController::class, 'criteriaIndex'])->name('criteria.index');
    Route::get('/criteria/create', [SuperAdminController::class, 'criteriaCreate'])->name('criteria.create');
    Route::post('/criteria', [SuperAdminController::class, 'criteriaStore'])->name('criteria.store');
    Route::get('/criteria/{criteria}/edit', [SuperAdminController::class, 'criteriaEdit'])->name('criteria.edit');
    Route::put('/criteria/{criteria}', [SuperAdminController::class, 'criteriaUpdate'])->name('criteria.update');
    Route::delete('/criteria/{criteria}', [SuperAdminController::class, 'criteriaDestroy'])->name('criteria.destroy');
    
    // Sub Criteria Management
    Route::get('/criteria/{criteria}/sub-criteria', [SuperAdminController::class, 'subCriteriaIndex'])->name('criteria.sub-criteria.index');
    Route::get('/criteria/{criteria}/sub-criteria/create', [SuperAdminController::class, 'subCriteriaCreate'])->name('criteria.sub-criteria.create');
    Route::post('/criteria/{criteria}/sub-criteria', [SuperAdminController::class, 'subCriteriaStore'])->name('criteria.sub-criteria.store');
    Route::get('/criteria/{criteria}/sub-criteria/{subCriteria}/edit', [SuperAdminController::class, 'subCriteriaEdit'])->name('criteria.sub-criteria.edit');
    Route::put('/criteria/{criteria}/sub-criteria/{subCriteria}', [SuperAdminController::class, 'subCriteriaUpdate'])->name('criteria.sub-criteria.update');
    Route::delete('/criteria/{criteria}/sub-criteria/{subCriteria}', [SuperAdminController::class, 'subCriteriaDestroy'])->name('criteria.sub-criteria.destroy');
    
    // AHP Weights Management
    Route::get('/ahp-weights', [SuperAdminController::class, 'ahpWeightsIndex'])->name('ahp-weights.index');
    Route::get('/ahp-weights/criteria', [SuperAdminController::class, 'ahpCriteriaWeights'])->name('ahp-weights.criteria');
    Route::post('/ahp-weights/criteria', [SuperAdminController::class, 'ahpCriteriaWeightsStore'])->name('ahp-weights.criteria.store');
    Route::get('/ahp-weights/sub-criteria/{criteria}', [SuperAdminController::class, 'ahpSubCriteriaWeights'])->name('ahp-weights.sub-criteria');
    Route::post('/ahp-weights/sub-criteria/{criteria}', [SuperAdminController::class, 'ahpSubCriteriaWeightsStore'])->name('ahp-weights.sub-criteria.store');
    
    // User Management 
    Route::get('/users', [SuperAdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users/create', [SuperAdminController::class, 'usersCreate'])->name('users.create');
    Route::post('/users', [SuperAdminController::class, 'usersStore'])->name('users.store');
    Route::get('/users/{user}', [SuperAdminController::class, 'usersShow'])->name('users.show');
    Route::get('/users/{user}/edit', [SuperAdminController::class, 'usersEdit'])->name('users.edit');
    Route::put('/users/{user}', [SuperAdminController::class, 'usersUpdate'])->name('users.update');
    Route::delete('/users/{user}', [SuperAdminController::class, 'usersDestroy'])->name('users.destroy');
    
    // Reports Management
    Route::get('/reports', [SuperAdminController::class, 'reportsIndex'])->name('reports.index');
    Route::get('/reports/evaluations', [SuperAdminController::class, 'reportsEvaluations'])->name('reports.evaluations');
    Route::get('/reports/customers', [SuperAdminController::class, 'reportsCustomers'])->name('reports.customers');
    Route::get('/reports/export', [SuperAdminController::class, 'reportsExport'])->name('reports.export');
});

// Admin Routes  
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Placeholder routes
    Route::get('/customers', function () { return 'Customer Management'; })->name('customers');
    Route::get('/evaluations', function () { return 'Evaluations'; })->name('evaluations');
});

// Shared Routes (both roles)
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    // Reports routes
});
