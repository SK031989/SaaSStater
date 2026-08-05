<?php

use Illuminate\Support\Facades\Route;
use Modules\Support\App\Http\Controllers\Api\TicketApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/tickets')
    ->name('api.tickets.')
    ->group(function () {
        Route::apiResource('/', TicketApiController::class)->parameters(['' => 'ticket']);
    });
