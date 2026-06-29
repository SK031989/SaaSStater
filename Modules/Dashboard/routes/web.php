<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\DashboardController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['web', 'auth'])->get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('auth.profile.edit');
})->name('dashboard');
