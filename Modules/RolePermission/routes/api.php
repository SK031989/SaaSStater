<?php

use Illuminate\Support\Facades\Route;
use Modules\RolePermission\App\Http\Controllers\Api\RolePermissionApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/rolepermissions')
    ->name('api.rolepermissions.')
    ->group(function () {
        Route::apiResource('/', RolePermissionApiController::class)->parameters(['' => 'role']);
    });
