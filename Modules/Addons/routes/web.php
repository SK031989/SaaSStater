<?php

use Illuminate\Support\Facades\Route;
use Modules\Addons\App\Http\Controllers\AddonController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/addons')
    ->name('addons.')
    ->group(function () {
        Route::get('/',             [AddonController::class, 'index'])->name('index');
        Route::get('/create',       [AddonController::class, 'create'])->name('create');
        Route::post('/store',       [AddonController::class, 'store'])->name('store');
        Route::post('/create',      [AddonController::class, 'store']); // Dual POST fallback
        Route::get('/{addon}',      [AddonController::class, 'show'])->name('show');
        Route::get('/{addon}/edit', [AddonController::class, 'edit'])->name('edit');
        Route::put('/{addon}',      [AddonController::class, 'update'])->name('update');
        Route::delete('/{addon}',   [AddonController::class, 'destroy'])->name('destroy');
    });
