<?php

use App\Http\Controllers\Admin\VehiculeController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\MissionOrderController;
use App\Http\Controllers\Admin\TireController;
use App\Http\Controllers\Admin\VidangeController;
use App\Http\Controllers\Admin\TiminChaineController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\HistoriqueStockController;
use App\Http\Controllers\Admin\MaintenenceController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PaymentVoucherController;
use App\Http\Controllers\Admin\VehiculeUpdateController;
use App\Http\Controllers\Admin\CategoriePermiController;
use App\Http\Controllers\Admin\ReformeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LanguageController;

Route::middleware(['auth'])->group(function () {

    Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('changelang');

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->group(function(){
        //Vehicules
        Route::get('vehicule', [VehiculeController::class, 'index'])->name('admin.vehicule');
        Route::get('vehicule/create', [VehiculeController::class, 'create'])->name('admin.vehicule.create');
        Route::post('vehicule/store', [VehiculeController::class, 'store'])->name('admin.vehicule.store');
        // Vehicle KM/Hours Update - must be before vehicule/{id} route
        Route::get('vehicule/update-km-hours', [VehiculeUpdateController::class, 'index'])->name('admin.vehicule.update.index');
        Route::get('vehicule/{id}/show', [VehiculeController::class, 'show'])->name('admin.vehicule.show');
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
        Route::delete('/driver/{id}', [DriverController::class, 'destroy'])->name('admin.driver.delete');


        //Mission Order (Ordre de Mission)
        Route::get('/mission-order', [MissionOrderController::class, 'index'])->name('admin.mission_order');
        Route::get('/mission-order/create', [MissionOrderController::class, 'create'])->name('admin.mission_order.create');
        Route::post('/mission-order/store', [MissionOrderController::class,'store'])->name('admin.mission_order.store');
        Route::get('/mission-order/{id}', [MissionOrderController::class,'edit'])->name('admin.mission_order.edit');
        Route::put('/mission-order/update/{id}',[MissionOrderController::class, 'update'])->name('admin.mission_order.update');
        Route::delete('/mission-order/destroy/{id}',[MissionOrderController::class, 'destroy'])->name('admin.mission_order.delete');
        Route::post('/mission-order/return/{id}', [MissionOrderController::class, 'returnFromMissionOrder'])->name('admin.mission_order.return');
        Route::get('/mission-order/print/{id}', [MissionOrderController::class, 'print'])->name('admin.mission_order.print');


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

        //Payment Vouchers (Bons de paiement)
        Route::get('/payment-voucher', [PaymentVoucherController::class, 'index'])->name('admin.payment_voucher.index');
        Route::get('/payment-voucher/category/{category}', [PaymentVoucherController::class, 'index'])->name('admin.payment_voucher.index.category');
        Route::get('/payment-voucher/create', [PaymentVoucherController::class, 'create'])->name('admin.payment_voucher.create');
        Route::get('/payment-voucher/create/{category}', [PaymentVoucherController::class, 'create'])->name('admin.payment_voucher.create.category');
        Route::get('/payment-voucher/get-insurance-expiration/{vehiculeId}', [PaymentVoucherController::class, 'getInsuranceExpiration'])->name('admin.payment_voucher.get_insurance_expiration');
        Route::get('/payment-voucher/get-technical-visit-expiration/{vehiculeId}', [PaymentVoucherController::class, 'getTechnicalVisitExpiration'])->name('admin.payment_voucher.get_technical_visit_expiration');
        Route::get('/payment-voucher/get-vehicle-km/{vehiculeId}', [PaymentVoucherController::class, 'getVehicleKm'])->name('admin.payment_voucher.get_vehicle_km');
        Route::post('/payment-voucher/store', [PaymentVoucherController::class, 'store'])->name('admin.payment_voucher.store');
        Route::get('/payment-voucher/{id}', [PaymentVoucherController::class, 'show'])->name('admin.payment_voucher.show');
        Route::get('/payment-voucher/{id}/edit', [PaymentVoucherController::class, 'edit'])->name('admin.payment_voucher.edit');
        Route::put('/payment-voucher/{id}', [PaymentVoucherController::class, 'update'])->name('admin.payment_voucher.update');
        Route::delete('/payment-voucher/{id}', [PaymentVoucherController::class, 'destroy'])->name('admin.payment_voucher.delete');

        //Vehicle KM/Hours Update - PUT route (already moved GET route above)
        Route::put('/vehicule/update-km-hours/{id}', [VehiculeUpdateController::class, 'update'])->name('admin.vehicule.update.km_hours');

        //Settings - Categorie Permis
        Route::get('/settings/categorie-permis', [CategoriePermiController::class, 'index'])->name('admin.categorie_permis.index');
        Route::get('/settings/categorie-permis/create', [CategoriePermiController::class, 'create'])->name('admin.categorie_permis.create');
        Route::post('/settings/categorie-permis', [CategoriePermiController::class, 'store'])->name('admin.categorie_permis.store');
        Route::get('/settings/categorie-permis/{id}/edit', [CategoriePermiController::class, 'edit'])->name('admin.categorie_permis.edit');
        Route::put('/settings/categorie-permis/{id}', [CategoriePermiController::class, 'update'])->name('admin.categorie_permis.update');
        Route::delete('/settings/categorie-permis/{id}', [CategoriePermiController::class, 'destroy'])->name('admin.categorie_permis.destroy');

        //Reformes
        Route::get('/reforme', [ReformeController::class, 'index'])->name('admin.reforme');
        Route::get('/reforme/create', [ReformeController::class, 'create'])->name('admin.reforme.create');
        Route::post('/reforme/store', [ReformeController::class, 'store'])->name('admin.reforme.store');
        Route::get('/reforme/{id}', [ReformeController::class, 'show'])->name('admin.reforme.show');
        Route::get('/reforme/{id}/edit', [ReformeController::class, 'edit'])->name('admin.reforme.edit');
        Route::post('/reforme/update/{id}', [ReformeController::class, 'update'])->name('admin.reforme.update');
        Route::post('/reforme/update-status/{id}', [ReformeController::class, 'updateStatus'])->name('admin.reforme.update-status');
        Route::post('/reforme/attachments/add', [ReformeController::class, 'addAttachments'])->name('admin.reforme.attachments.add');
        Route::delete('/reforme/attachments/delete/{id}', [ReformeController::class, 'deleteAttachment'])->name('admin.reforme.attachments.delete');
        Route::delete('/reforme/status-attachments/delete/{id}', [ReformeController::class, 'deleteStatusAttachment'])->name('admin.reforme.status-attachments.delete');
        Route::delete('/reforme/{id}', [ReformeController::class, 'destroy'])->name('admin.reforme.delete');

        //Users (Admin only)
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.delete');
    });
});
