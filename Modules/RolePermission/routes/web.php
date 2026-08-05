<?php

use Illuminate\Support\Facades\Route;
use Modules\RolePermission\App\Http\Controllers\RolePermissionController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/rolepermissions')
    ->name('rolepermissions.')
    ->group(function () {
        Route::get('/',             [RolePermissionController::class, 'index'])->name('index');
        Route::get('/create',       [RolePermissionController::class, 'create'])->name('create');
        Route::post('/store',       [RolePermissionController::class, 'store'])->name('store');
        Route::post('/create',      [RolePermissionController::class, 'store']); // Dual POST fallback
        Route::get('/{role}',       [RolePermissionController::class, 'show'])->name('show');
        Route::get('/{role}/edit',  [RolePermissionController::class, 'edit'])->name('edit');
        Route::put('/{role}',       [RolePermissionController::class, 'update'])->name('update');
        Route::delete('/{role}',    [RolePermissionController::class, 'destroy'])->name('destroy');
    });
