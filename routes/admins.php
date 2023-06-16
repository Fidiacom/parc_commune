<?php

use App\Http\Controllers\Admin\VehiculeController;
use App\Http\Controllers\Admin\DriverController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function(){

        //Vehicules
        Route::get('vehicule', [VehiculeController::class, 'index'])->name('admin.vehicule');
        Route::get('vehicule/create', [VehiculeController::class, 'create'])->name('admin.vehicule.create');
        Route::post('vehicule/store', [VehiculeController::class, 'store'])->name('admin.vehicule.store');


        //Drivers
        Route::get('/driver', [DriverController::class, 'index'])->name('admin.drivers');
        Route::get('/driver/create', [DriverController::class, 'create'])->name('admin.drivers.create');
    });
});
