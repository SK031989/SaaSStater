<?php

use Illuminate\Support\Facades\Route;
use Modules\Addons\App\Http\Controllers\Api\AddonApiController;

Route::middleware(['api'])
    ->prefix('api/v1/addons')
    ->name('api.addons.')
    ->group(function () {
        Route::get('/', [AddonApiController::class, 'index'])->name('index');
        Route::post('/', [AddonApiController::class, 'store'])->name('store');
        Route::get('/{id}', [AddonApiController::class, 'show'])->name('show');
        Route::put('/{id}', [AddonApiController::class, 'update'])->name('update');
        Route::delete('/{id}', [AddonApiController::class, 'destroy'])->name('destroy');
    });
