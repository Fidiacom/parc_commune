<?php
use App\http\Controllers\ServiceTechnique\SettingController;


Route::prefix('service-technique')->group(function(){

    Route::get('settings', [SettingController::class, 'index'])->name('serviceTechnique.setting');
});
