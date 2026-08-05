<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\App\Http\Controllers\BillingController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/billings')
    ->name('billings.')
    ->group(function () {
        Route::get('/',             [BillingController::class, 'index'])->name('index');
        Route::get('/create',       [BillingController::class, 'create'])->name('create');
        Route::post('/store',       [BillingController::class, 'store'])->name('store');
        Route::post('/create',      [BillingController::class, 'store']); // Dual POST fallback
        Route::get('/{invoice}',    [BillingController::class, 'show'])->name('show');
        Route::get('/{invoice}/edit',[BillingController::class, 'edit'])->name('edit');
        Route::put('/{invoice}',    [BillingController::class, 'update'])->name('update');
        Route::delete('/{invoice}', [BillingController::class, 'destroy'])->name('destroy');
    });
