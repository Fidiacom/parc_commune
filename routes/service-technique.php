<?php
use App\Http\Controllers\ServiceTechnique\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'service.technique'])->prefix('service-technique')->group(function(){
    Route::get('settings', [SettingController::class, 'index'])->name('serviceTechnique.setting');
    Route::put('settings', [SettingController::class, 'update'])->name('serviceTechnique.setting.update');
});
