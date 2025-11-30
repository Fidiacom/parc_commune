<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Explicitly register components to avoid case-sensitivity issues on Linux servers
        // Using full class name strings to ensure proper resolution
        Blade::component('admin.app', \App\View\Components\Admin\App::class);
        Blade::component('serviceTechnique.app', \App\View\Components\serviceTechnique\App::class);
    }
}
