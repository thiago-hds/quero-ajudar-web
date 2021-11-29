<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // register components
        Blade::componentNamespace('App\\View\\Components\\Form', 'form.organization-select');
        Blade::componentNamespace('App\\View\\Components\\Form', 'form.causes-select');
        Blade::componentNamespace('App\\View\\Components\\Form', 'form.skills-select');

        // configure paginator
        Paginator::useBootstrap();
    }
}
