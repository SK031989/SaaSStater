<?php

use Illuminate\Support\Facades\Route;
use Modules\Coupons\App\Http\Controllers\Api\CouponApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/coupons')
    ->name('api.coupons.')
    ->group(function () {
        Route::apiResource('/', CouponApiController::class)->parameters(['' => 'coupon']);
    });
