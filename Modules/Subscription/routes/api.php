<?php

use Illuminate\Support\Facades\Route;
use Modules\Subscription\App\Http\Controllers\Api\SubscriptionApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/subscriptions')
    ->name('api.subscriptions.')
    ->group(function () {
        Route::apiResource('/', SubscriptionApiController::class)->parameters(['' => 'subscription']);
    });
