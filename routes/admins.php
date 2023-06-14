<?php

use App\Http\Controllers\Admin\VehiculeController;

Route::middleware(['auth'])->group(function () {
});
Route::prefix('admin')->group(function(){

    Route::get('vehicule', [VehiculeController::class, 'index'])->name('admin.vehicule');
    Route::get('vehicule/create', [VehiculeController::class, 'create'])->name('admin.vehicule.create');
});
