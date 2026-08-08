<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\App\Http\Controllers\PaymentController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/gateways/{gateway}/edit', [PaymentController::class, 'edit'])->name('payments.gateways.edit');
    Route::put('/payments/gateways/{gateway}', [PaymentController::class, 'update'])->name('payments.gateways.update');
    Route::post('/payments/gateways/{gateway}/toggle', [PaymentController::class, 'toggle'])->name('payments.gateways.toggle');
    Route::get('/payments/transactions/{transaction}', [PaymentController::class, 'showTransaction'])->name('payments.transactions.show');
});
