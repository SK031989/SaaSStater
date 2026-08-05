<?php

use Illuminate\Support\Facades\Route;
use Modules\Addons\App\Http\Controllers\Api\AddonApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/addons')
    ->name('api.addons.')
    ->group(function () {
        Route::apiResource('/', AddonApiController::class)->parameters(['' => 'addon']);
    });
