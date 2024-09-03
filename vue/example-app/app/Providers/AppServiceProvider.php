<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema as FacadesSchema;
use Illuminate\Support\ServiceProvider;
use Nette\Schema\Schema as SchemaSchema;
use schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
        FacadesSchema::defaultStringLength(191);
    }
}
