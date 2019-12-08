<?php

namespace App\Providers;

use mmghv\LumenRouteBinding\RouteBindingServiceProvider as BaseServiceProvider;

class RouteBindingServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // The binder instance
        $binder = $this->binder;
        // Here we define our bindings
        // $binder->bind('product', 'App\Models\Products');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
