<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\App\Http\Controllers\Api\BillingApiController;

Route::middleware(['api'])
    ->prefix('api/v1/billings')
    ->name('api.billings.')
    ->group(function () {
        Route::get('/', [BillingApiController::class, 'index'])->name('index');
        Route::post('/', [BillingApiController::class, 'store'])->name('store');
        Route::post('/checkout', [BillingApiController::class, 'checkout'])->name('checkout');
        Route::get('/{id}', [BillingApiController::class, 'show'])->name('show');
        Route::put('/{id}', [BillingApiController::class, 'update'])->name('update');
        Route::delete('/{id}', [BillingApiController::class, 'destroy'])->name('destroy');
    });

// Public / Guest Onboarding Checkout API Endpoint
Route::middleware(['api'])
    ->prefix('api/v1')
    ->group(function () {
        Route::post('/checkout', [BillingApiController::class, 'checkout'])->name('api.checkout');
    });
