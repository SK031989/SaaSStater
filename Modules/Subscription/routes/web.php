<?php

use Illuminate\Support\Facades\Route;
use Modules\Subscription\App\Http\Controllers\SubscriptionController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/subscriptions')
    ->name('subscriptions.')
    ->group(function () {
        Route::get('/',             [SubscriptionController::class, 'index'])->name('index');
        Route::get('/create',       [SubscriptionController::class, 'create'])->name('create');
        Route::post('/store',       [SubscriptionController::class, 'store'])->name('store');
        Route::post('/create',      [SubscriptionController::class, 'store']); // Dual POST fallback
        Route::get('/{plan}',       [SubscriptionController::class, 'show'])->name('show');
        Route::get('/{plan}/edit',  [SubscriptionController::class, 'edit'])->name('edit');
        Route::put('/{plan}',       [SubscriptionController::class, 'update'])->name('update');
        Route::delete('/{plan}',    [SubscriptionController::class, 'destroy'])->name('destroy');
    });
