<?php

use Illuminate\Support\Facades\Route;
use Modules\Location\App\Http\Controllers\Api\LocationApiController;

Route::prefix('v1')->middleware(['api', 'auth:sanctum'])->group(function () {
    Route::apiResource('locations', LocationApiController::class);
});
