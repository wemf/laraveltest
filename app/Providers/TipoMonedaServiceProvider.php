<?php

namespace App\Providers;
use App\TipoMoneda;
use Illuminate\Support\ServiceProvider;

class TipoMonedaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('view', function () {
            //
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TipoMoneda::class, function ($app) {
            return new TipoMoneda(config('moneda'));
        });
    }
}
