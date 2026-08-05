<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\App\Http\Controllers\Api\NotificationApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/notifications')
    ->name('api.notifications.')
    ->group(function () {
        Route::apiResource('/', NotificationApiController::class)->parameters(['' => 'log']);
    });
