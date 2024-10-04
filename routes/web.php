<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\DashboardController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
