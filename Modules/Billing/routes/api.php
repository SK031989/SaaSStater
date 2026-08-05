<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\App\Http\Controllers\Api\BillingApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/billings')
    ->name('api.billings.')
    ->group(function () {
        Route::apiResource('/', BillingApiController::class)->parameters(['' => 'invoice']);
    });
