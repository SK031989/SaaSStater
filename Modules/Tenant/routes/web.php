<?php

use Illuminate\Support\Facades\Route;
use Modules\Tenant\App\Http\Controllers\TenantController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/tenants')
    ->name('tenants.')
    ->group(function () {
        Route::get('/',             [TenantController::class, 'index'])->name('index');
        Route::get('/create',       [TenantController::class, 'create'])->name('create');
        Route::post('/store',       [TenantController::class, 'store'])->name('store');
        Route::post('/create',      [TenantController::class, 'store']); // Dual POST fallback
        Route::get('/{tenant}',     [TenantController::class, 'show'])->name('show');
        Route::get('/{tenant}/edit',[TenantController::class, 'edit'])->name('edit');
        Route::put('/{tenant}',     [TenantController::class, 'update'])->name('update');
        Route::delete('/{tenant}',  [TenantController::class, 'destroy'])->name('destroy');
    });
