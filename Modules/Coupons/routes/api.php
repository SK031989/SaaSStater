<?php

use Illuminate\Support\Facades\Route;
use Modules\Coupons\App\Http\Controllers\Api\CouponApiController;

Route::middleware(['api'])
    ->prefix('api/v1/coupons')
    ->name('api.coupons.')
    ->group(function () {
        Route::get('/', [CouponApiController::class, 'index'])->name('index');
        Route::post('/', [CouponApiController::class, 'store'])->name('store');
        Route::get('/{id}', [CouponApiController::class, 'show'])->name('show');
        Route::put('/{id}', [CouponApiController::class, 'update'])->name('update');
        Route::delete('/{id}', [CouponApiController::class, 'destroy'])->name('destroy');
    });
