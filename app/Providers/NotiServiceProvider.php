<?php

namespace App\Providers;
use App\Notificacion;
use Illuminate\Support\ServiceProvider;

class NotiServiceProvider extends ServiceProvider
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
        $this->app->singleton(Notificacion::class, function ($app) {
            return new Notificacion(config('noti'));
        });
    }
}
