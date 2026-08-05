<?php

use Illuminate\Support\Facades\Route;
use Modules\Support\App\Http\Controllers\TicketController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/tickets')
    ->name('tickets.')
    ->group(function () {
        Route::get('/',              [TicketController::class, 'index'])->name('index');
        Route::get('/create',        [TicketController::class, 'create'])->name('create');
        Route::post('/store',        [TicketController::class, 'store'])->name('store');
        Route::post('/create',       [TicketController::class, 'store']); // Dual POST fallback
        Route::get('/{ticket}',      [TicketController::class, 'show'])->name('show');
        Route::get('/{ticket}/edit', [TicketController::class, 'edit'])->name('edit');
        Route::put('/{ticket}',      [TicketController::class, 'update'])->name('update');
        Route::delete('/{ticket}',   [TicketController::class, 'destroy'])->name('destroy');
    });
