<?php

use Illuminate\Support\Facades\Route;
use Modules\ApiKey\App\Http\Controllers\Api\ApiKeyApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/apikeys')
    ->name('api.apikeys.')
    ->group(function () {
        Route::apiResource('/', ApiKeyApiController::class)->parameters(['' => 'apiKey']);
    });
