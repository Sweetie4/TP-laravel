<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'box'], function () {
    Route::get('{owner_id}', [BoxController::class, 'show'])->middleware(['auth', 'verified'])->name('box.show');
    Route::get('edit/{id}', [BoxController::class, 'edit'])->middleware(['auth', 'verified'])->name('box.edit');
    Route::post('', [BoxController::class, 'store'])->name('box.store');
    Route::delete('{id}/{owner_id}', [BoxController::class, 'destroy'])->name('box.destroy');
    Route::put('{id}/{owner_id}', [BoxController::class, 'update'])->name('box.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
