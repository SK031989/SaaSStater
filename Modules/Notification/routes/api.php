<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\App\Http\Controllers\Api\NotificationApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/notifications')
    ->name('api.notifications.')
    ->group(function () {
        Route::get('/',                 [NotificationApiController::class, 'index'])->name('index');
        Route::post('/',                [NotificationApiController::class, 'store'])->name('store');
        Route::get('/{id}',             [NotificationApiController::class, 'show'])->name('show');
        Route::put('/{id}/read',        [NotificationApiController::class, 'markRead'])->name('read');
        Route::delete('/{id}',          [NotificationApiController::class, 'destroy'])->name('destroy');
    });
