<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModelContractController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'box'], function () {
    Route::get('{owner_id}', [BoxController::class, 'show'])->middleware(['auth', 'verified'])->name('box.show');
    Route::get('edit/{id}', [BoxController::class, 'edit'])->middleware(['auth', 'verified'])->name('box.edit');
    Route::post('', [BoxController::class, 'store'])->name('box.store');
    Route::delete('{id}/{owner_id}', [BoxController::class, 'destroy'])->name('box.destroy');
    Route::put('{id}/{owner_id}', [BoxController::class, 'update'])->name('box.update');
});

Route::group(['prefix' => 'tenant'], function () {
    Route::get('{owner_id}', [TenantController::class, 'show'])->middleware(['auth', 'verified'])->name('tenant.show');
    Route::get('edit/{id}', [TenantController::class, 'edit'])->middleware(['auth', 'verified'])->name('tenant.edit');
    Route::post('', [TenantController::class, 'store'])->name('tenant.store');
    Route::delete('{id}/{owner_id}', [TenantController::class, 'destroy'])->name('tenant.destroy');
    Route::put('{id}/{owner_id}', [TenantController::class, 'update'])->name('tenant.update');
});



Route::group(['prefix' => 'contracts'], function () {
    Route::group(['prefix' => 'models'], function () {
        Route::get('{owner_id}', [ModelContractController::class, 'show'])->middleware(['auth', 'verified'])->name('model-contracts.show');
        Route::get('edit/{id}', [ModelContractController::class, 'edit'])->middleware(['auth', 'verified'])->name('model-contracts.edit');
        Route::post('', [ModelContractController::class, 'store'])->name('model-contracts.store');
        Route::delete('{id}/{owner_id}', [ModelContractController::class, 'destroy'])->name('model-contracts.destroy');
        Route::put('{id}/{owner_id}', [ModelContractController::class, 'update'])->name('model-contracts.update');
    });
    Route::get('{type}/{id}/{logged_id}', [ContratController::class, 'create'])->middleware(['auth', 'verified'])->name('contrats.create');
    Route::post('', [ContratController::class, 'store'])->middleware(['auth', 'verified'])->name('contracts.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
