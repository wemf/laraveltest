<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use dateFormate;

class ResponseFormatDateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('dateFormat', function ($input) { 
           return Response::make(dateFormate::ToFormat($input));
        });

        Response::macro('dateFormatJson', function ($input) {  
            return Response::make(dateFormate::ToJson($input));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
