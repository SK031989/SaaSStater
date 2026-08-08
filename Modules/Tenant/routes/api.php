<?php

use Illuminate\Support\Facades\Route;
use Modules\Tenant\App\Http\Controllers\Api\TenantApiController;

Route::middleware(['api'])
    ->prefix('api/v1/tenants')
    ->name('api.tenants.')
    ->group(function () {
        Route::get('/', [TenantApiController::class, 'index'])->name('index');
        Route::post('/', [TenantApiController::class, 'store'])->name('store');
        Route::get('/{id}', [TenantApiController::class, 'show'])->name('show');
        Route::put('/{id}', [TenantApiController::class, 'update'])->name('update');
        Route::delete('/{id}', [TenantApiController::class, 'destroy'])->name('destroy');
    });
