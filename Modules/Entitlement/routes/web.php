<?php

use Illuminate\Support\Facades\Route;
use Modules\Entitlement\App\Http\Controllers\EntitlementController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/entitlements')
    ->name('entitlements.')
    ->group(function () {
        Route::get('/',                 [EntitlementController::class, 'index'])->name('index');
        Route::get('/create',           [EntitlementController::class, 'create'])->name('create');
        Route::post('/store',           [EntitlementController::class, 'store'])->name('store');
        Route::post('/create',          [EntitlementController::class, 'store']); // Dual POST fallback
        Route::get('/{entitlement}',     [EntitlementController::class, 'show'])->name('show');
        Route::get('/{entitlement}/edit',[EntitlementController::class, 'edit'])->name('edit');
        Route::put('/{entitlement}',     [EntitlementController::class, 'update'])->name('update');
        Route::delete('/{entitlement}',  [EntitlementController::class, 'destroy'])->name('destroy');
    });
