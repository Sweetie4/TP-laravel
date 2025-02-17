<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModelContractController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\TenantController;
use App\Models\Contract;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'box'], function () {
    Route::get('{owner_id}', [BoxController::class, 'show'])->middleware(['auth', 'verified'])->name('box.show');
    Route::get('edit/{id}', [BoxController::class, 'edit'])->middleware(['auth', 'verified'])->name('box.edit');
    Route::post('', [BoxController::class, 'store'])->middleware(['auth', 'verified'])->name('box.store');
    Route::delete('{id}/{owner_id}', [BoxController::class, 'destroy'])->middleware(['auth', 'verified'])->name('box.destroy');
    Route::put('{id}/{owner_id}', [BoxController::class, 'update'])->middleware(['auth', 'verified'])->name('box.update');
});

Route::group(['prefix' => 'tenant'], function () {
    Route::get('{owner_id}', [TenantController::class, 'show'])->middleware(['auth', 'verified'])->name('tenant.show');
    Route::get('edit/{id}', [TenantController::class, 'edit'])->middleware(['auth', 'verified'])->name('tenant.edit');
    Route::post('', [TenantController::class, 'store'])->middleware(['auth', 'verified'])->name('tenant.store');
    Route::delete('{id}/{owner_id}', [TenantController::class, 'destroy'])->middleware(['auth', 'verified'])->name('tenant.destroy');
    Route::put('{id}/{owner_id}', [TenantController::class, 'update'])->middleware(['auth', 'verified'])->name('tenant.update');
});



Route::group(['prefix' => 'contracts'], function () {
    Route::group(['prefix' => 'models'], function () {
        Route::get('{owner_id}', [ModelContractController::class, 'show'])->middleware(['auth', 'verified'])->name('model-contracts.show');
        Route::get('edit/{id}', [ModelContractController::class, 'edit'])->middleware(['auth', 'verified'])->name('model-contracts.edit');
        Route::post('', [ModelContractController::class, 'store'])->middleware(['auth', 'verified'])->name('model-contracts.store');
        Route::delete('{id}/{owner_id}', [ModelContractController::class, 'destroy'])->middleware(['auth', 'verified'])->name('model-contracts.destroy');
        Route::put('{id}/{owner_id}', [ModelContractController::class, 'update'])->middleware(['auth', 'verified'])->name('model-contracts.update');
    });
    Route::get('{owner_id}', [ContratController::class, 'show'])->middleware(['auth', 'verified'])->name('contracts.show');
    Route::get('{type}/{id}/{logged_id}', [ContratController::class, 'create'])->middleware(['auth', 'verified'])->name('contrats.create');
    Route::post('', [ContratController::class, 'store'])->middleware(['auth', 'verified'])->name('contracts.store');
    Route::delete('{id}/{owner_id}', [ContratController::class, 'destroy'])->middleware(['auth', 'verified'])->name('contracts.destroy');
    Route::get('/download/{file_name}', [ContratController::class, 'download'])->middleware(['auth', 'verified'])->name('contract.download');
});

Route::group(['prefix' => 'payments'], function() {
    Route::get('{owner_id}/{month}', [PaymentController::class, 'show'])->middleware(['auth', 'verified'])->name('payments.show');
    Route::put('{payment_id}', [PaymentController::class, 'update'])->middleware(['auth', 'verified'])->name('payments.update');
}); 

Route::group(['prefix' => 'bills'], function() {
    Route::get('download/{file_name}', [PaymentController::class, 'download'])->middleware(['auth', 'verified'])->name('bills.download');
    Route::get('{owner_id}/{month}', [PaymentController::class, 'showBills'])->middleware(['auth', 'verified'])->name('bills.show');
}); 

Route::group(['prefix'=>'taxes'], function() {
    Route::get('{user_id}', [TaxesController::class, 'show'])->middleware(['auth', 'verified'])->name('taxes.show');
    Route::post('', [TaxesController::class, 'generate'])->middleware(['auth', 'verified'])->name('taxes.calculate');
    Route::post('/export', [TaxesController::class, 'export'])->middleware(['auth', 'verified'])->name('taxes.export');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware(['auth', 'verified'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware(['auth', 'verified'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware(['auth', 'verified'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
