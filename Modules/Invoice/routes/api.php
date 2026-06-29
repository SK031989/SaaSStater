<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\App\Http\Controllers\InvoiceApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/invoices')
    ->name('api.invoices.')
    ->group(function () {
        Route::apiResource('/', InvoiceApiController::class)->parameters(['' => 'invoices']);
    });