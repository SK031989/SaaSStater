<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\App\Http\Controllers\InvoiceController;

Route::middleware(['web', 'auth', 'verified'])
    ->prefix('invoices')
    ->name('invoices.')
    ->group(function () {
        Route::resource('/', InvoiceController::class)->parameters(['' => 'invoices']);
    });