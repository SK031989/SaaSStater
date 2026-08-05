<?php

use Illuminate\Support\Facades\Route;
use Modules\Tenant\App\Http\Controllers\Api\TenantApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/tenants')
    ->name('api.tenants.')
    ->group(function () {
        Route::apiResource('/', TenantApiController::class)->parameters(['' => 'tenant']);
    });
