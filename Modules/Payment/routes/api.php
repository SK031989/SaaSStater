<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\App\Http\Controllers\Api\PaymentApiController;

Route::prefix('v1')->middleware(['api', 'auth:sanctum'])->group(function () {
    Route::get('/payments/gateways', [PaymentApiController::class, 'gateways']);
    Route::get('/payments/transactions', [PaymentApiController::class, 'transactions']);
    Route::post('/payments/transactions', [PaymentApiController::class, 'storeTransaction']);
});
