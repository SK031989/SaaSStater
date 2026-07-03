<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\DashboardController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/privacy-policy',  [DashboardController::class, 'privacyPolicy'])->name('admin.privacy-policy');
    Route::get('/admin/terms-of-service', [DashboardController::class, 'termsOfService'])->name('admin.terms-of-service');
    Route::get('/admin/support',          [DashboardController::class, 'support'])->name('admin.support');
});

Route::middleware(['web', 'auth'])->get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('auth.profile.edit');
})->name('dashboard');
