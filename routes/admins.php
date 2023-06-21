<?php

use App\Http\Controllers\Admin\VehiculeController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\TireController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function(){


        //Vehicules
        Route::get('vehicule', [VehiculeController::class, 'index'])->name('admin.vehicule');
        Route::get('vehicule/create', [VehiculeController::class, 'create'])->name('admin.vehicule.create');
        Route::post('vehicule/store', [VehiculeController::class, 'store'])->name('admin.vehicule.store');
        Route::get('vehicule/{id}', [VehiculeController::class, 'edit'])->name('admin.vehicule.edit');
        Route::post('vehicule/update/{id}', [VehiculeController::class, 'update'])->name('admin.vehicule.update');
        //tires
        Route::get('vehicule/tires/create/{carId}', [TireController::class, 'create'])->name('admin.tire.create');
        Route::post('vehicule/tires/store', [TireController::class, 'store'])->name('admin.tire.store');
        //Drivers
        Route::get('/driver', [DriverController::class, 'index'])->name('admin.drivers');
        Route::get('/driver/create', [DriverController::class, 'create'])->name('admin.drivers.create');
        Route::post('/driver/store', [DriverController::class, 'store'])->name('admin.driver.store');


        //Trip (Voyage)
        Route::get('/trip', [TripController::class, 'index'])->name('admin.trip');
    });
});
