<?php

use Illuminate\Support\Facades\Route;
use Modules\Entitlement\App\Http\Controllers\Api\EntitlementApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/entitlements')
    ->name('api.entitlements.')
    ->group(function () {
        Route::apiResource('/', EntitlementApiController::class)->parameters(['' => 'entitlement']);
    });
