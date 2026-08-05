<?php

use Illuminate\Support\Facades\Route;
use Modules\ApiKey\App\Http\Controllers\ApiKeyController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/apikeys')
    ->name('apikeys.')
    ->group(function () {
        Route::get('/',             [ApiKeyController::class, 'index'])->name('index');
        Route::get('/create',       [ApiKeyController::class, 'create'])->name('create');
        Route::post('/store',       [ApiKeyController::class, 'store'])->name('store');
        Route::post('/create',      [ApiKeyController::class, 'store']); // Dual POST fallback
        Route::get('/{apiKey}',     [ApiKeyController::class, 'show'])->name('show');
        Route::get('/{apiKey}/edit',[ApiKeyController::class, 'edit'])->name('edit');
        Route::put('/{apiKey}',     [ApiKeyController::class, 'update'])->name('update');
        Route::delete('/{apiKey}',  [ApiKeyController::class, 'destroy'])->name('destroy');
    });
