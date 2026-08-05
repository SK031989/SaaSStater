<?php

use Illuminate\Support\Facades\Route;
use Modules\Coupons\App\Http\Controllers\CouponController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/coupons')
    ->name('coupons.')
    ->group(function () {
        Route::get('/',             [CouponController::class, 'index'])->name('index');
        Route::get('/create',       [CouponController::class, 'create'])->name('create');
        Route::post('/store',       [CouponController::class, 'store'])->name('store');
        Route::post('/create',      [CouponController::class, 'store']); // Dual POST fallback
        Route::get('/{coupon}',     [CouponController::class, 'show'])->name('show');
        Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('edit');
        Route::put('/{coupon}',     [CouponController::class, 'update'])->name('update');
        Route::delete('/{coupon}',  [CouponController::class, 'destroy'])->name('destroy');
    });
