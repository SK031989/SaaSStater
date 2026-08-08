<?php

use Illuminate\Support\Facades\Route;
use Modules\Location\App\Http\Controllers\LocationController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('locations', LocationController::class);
});
