<?php

use Illuminate\Support\Facades\Route;
use Modules\Subscription\App\Http\Controllers\Api\SubscriptionApiController;

Route::middleware(['api'])
    ->prefix('api/v1/subscriptions')
    ->name('api.subscriptions.')
    ->group(function () {
        Route::get('/', [SubscriptionApiController::class, 'index'])->name('index');
        Route::post('/', [SubscriptionApiController::class, 'store'])->name('store');
        Route::get('/{id}', [SubscriptionApiController::class, 'show'])->name('show');
        Route::put('/{id}', [SubscriptionApiController::class, 'update'])->name('update');
        Route::delete('/{id}', [SubscriptionApiController::class, 'destroy'])->name('destroy');
    });
