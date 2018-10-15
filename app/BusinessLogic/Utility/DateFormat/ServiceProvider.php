<?php
namespace App\BusinessLogic\Utility\DateFormat;

use App\BusinessLogic\Utility\DateFormat\Date;
use Exception;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
     /**
     * Register the service provider.
     *
     * @throws \Exception
     * @return void
     */
    public function register()
    {
        $this->app->bind('dateFormate', function() {
            $dateFormate = new Date();
            return $dateFormate;
        });
        
        $this->app->alias('dateFormate',Date::class);

        $this->app->bind('dateFormate.wrapper', function ($app) {
            return new Date($app['dateFormate']);
        });
    }
}
