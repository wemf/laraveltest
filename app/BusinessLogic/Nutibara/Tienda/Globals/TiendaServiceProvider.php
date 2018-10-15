<?php
namespace App\BusinessLogic\Nutibara\Tienda\Globals;

use App\BusinessLogic\Nutibara\Tienda\Globals\IpBrowser;
use Exception;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class TiendaServiceProvider extends IlluminateServiceProvider
{
     /**
     * Register the service provider.
     *
     * @throws \Exception
     * @return void
     */
    public function register()
    {
        $this->app->bind('tienda', function() {
            $tienda = new IpBrowser();
            return $tienda;
        });
        
        $this->app->alias('tienda',IpBrowser::class);

        $this->app->bind('tienda.wrapper', function ($app) {
            return new IpBrowser($app['tienda']);
        });
    }
}
