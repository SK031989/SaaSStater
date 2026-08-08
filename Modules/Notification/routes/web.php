<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\App\Http\Controllers\NotificationController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/notifications')
    ->name('notifications.')
    ->group(function () {
        Route::get('/',                     [NotificationController::class, 'index'])->name('index');
        Route::get('/create',               [NotificationController::class, 'create'])->name('create');
        Route::post('/store',               [NotificationController::class, 'store'])->name('store');
        Route::post('/create',              [NotificationController::class, 'store']); // Dual POST fallback
        Route::post('/settings',            [NotificationController::class, 'updateSettings'])->name('settings.update');
        Route::put('/{notification}/read',  [NotificationController::class, 'markAsRead'])->name('read');
        Route::get('/item/{notification}',  [NotificationController::class, 'showNotification'])->name('view');
        Route::get('/{log}',                [NotificationController::class, 'show'])->name('show');
        Route::get('/{log}/edit',           [NotificationController::class, 'edit'])->name('edit');
        Route::put('/{log}',                [NotificationController::class, 'update'])->name('update');
        Route::delete('/{notification}',    [NotificationController::class, 'destroy'])->name('destroy');
    });
