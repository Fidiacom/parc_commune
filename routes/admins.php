<?php

use App\Http\Controllers\Admin\VehiculeController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\TireController;
use App\Http\Controllers\Admin\VidangeController;
use App\Http\Controllers\Admin\TiminChaineController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\HistoriqueStockController;
use App\Http\Controllers\Admin\MaintenenceController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\LanguageController;

Route::middleware(['auth'])->group(function () {

    Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('changelang');

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->group(function(){
        //Vehicules
        Route::get('vehicule', [VehiculeController::class, 'index'])->name('admin.vehicule');
        Route::get('vehicule/create', [VehiculeController::class, 'create'])->name('admin.vehicule.create');
        Route::post('vehicule/store', [VehiculeController::class, 'store'])->name('admin.vehicule.store');
        Route::get('vehicule/{id}', [VehiculeController::class, 'edit'])->name('admin.vehicule.edit');
        Route::post('vehicule/update/{id}', [VehiculeController::class, 'update'])->name('admin.vehicule.update');
        Route::post('vehicule/images/add', [VehiculeController::class, 'addImages'])->name('admin.vehicule.images.add');
        Route::delete('vehicule/images/delete/{id}', [VehiculeController::class, 'deleteImage'])->name('admin.vehicule.images.delete');
        Route::post('vehicule/images/set-main', [VehiculeController::class, 'setMainImage'])->name('admin.vehicule.images.set-main');
        Route::post('vehicule/attachments/add', [VehiculeController::class, 'addAttachments'])->name('admin.vehicule.attachments.add');
        Route::delete('vehicule/attachments/delete/{id}', [VehiculeController::class, 'deleteAttachment'])->name('admin.vehicule.attachments.delete');
        Route::delete('vehicule/{id}', [VehiculeController::class, 'destroy'])->name('admin.vehicule.delete');

        Route::get('vehicule/drain-tire-timing/{vehicule_id}', [VehiculeController::class, 'dtt_get'])->name('admin.dtt');

        //Route::post('/vehicule/drain/update/{id}', [VidangeController::class, 'update_seuil'])->name('admin.drain.update_sei');
        Route::post('/vehicule/drain/{vehicule_id}', [VidangeController::class, 'update'])->name('admin.drain.update');

        Route::post('/vehicule/timingchaine/update/{id}', [TiminChaineController::class, 'update'])->name('admin.timingchaine.update');

        Route::post('/vehicule/pneu/update/{id}', [TireController::class, 'update'])->name('admin.pneu.update');

        //tires
        Route::get('vehicule/tires/create/{carId}', [TireController::class, 'create'])->name('admin.tire.create');
        Route::post('vehicule/tires/store', [TireController::class, 'store'])->name('admin.tire.store');

        //Drivers
        Route::get('/driver', [DriverController::class, 'index'])->name('admin.drivers');
        Route::get('/driver/create', [DriverController::class, 'create'])->name('admin.drivers.create');
        Route::post('/driver/store', [DriverController::class, 'store'])->name('admin.driver.store');
        Route::get('/drive/{id}', [DriverController::class, 'edit'])->name('admin.driver.edit');
        Route::post('/driver/update/{id}', [DriverController::class, 'update'])->name('admin.driver.update');


        //Trip (Voyage)
        Route::get('/trip', [TripController::class, 'index'])->name('admin.trip');
        Route::get('/trip/create', [TripController::class, 'create'])->name('admin.trip.create');
        Route::post('/trip/store', [TripController::class,'store'])->name('admin.trip.store');
        Route::get('/trip/{id}', [TripController::class,'edit'])->name('admin.trip.edit');
        Route::put('/trip/update/{id}',[TripController::class, 'update'])->name('admin.trip.update');
        Route::delete('/trip/destroy/{id}',[TripController::class, 'destroy'])->name('admin.trip.delete');
        Route::post('/trip/return/{id}', [TripController::class, 'returnFromTrip'])->name('admin.trip.return');


        //Stock
        Route::get('/stock', [StockController::class,'index'])->name('admin.stock');
        Route::get('/stock-entry',[StockController::class,'create_stock'])->name('admin.stock-entry');
        Route::post('/stock/store', [StockController::class,'store'])->name('admin.stock.store');
        Route::put('/stock/update/{id}', [StockController::class, 'update'])->name('admin.stock.update');
        Route::delete('/stock/delete', [StockController::class, 'destroy'])->name('admin.stock.destroy');

        //Stock Historie
        Route::post('/stock_historique', [HistoriqueStockController::class, 'store'])->name('admin.stock_history.store');
        Route::get('/historique_stock',[HistoriqueStockController::class, 'index'])->name('admin.stockHistorie');


        //maintenance
        //Route::get('/maintenence', [MaintenenceController::class, 'index'])->name('admin.maintenance');
        Route::get('/maintenence/create/{id}', [MaintenenceController::class, 'create'])->name('admin.maintenance.create');
        Route::post('/maintenance/store', [MaintenenceController::class, 'store'])->name('admin.maintenance.store');
    });
});
