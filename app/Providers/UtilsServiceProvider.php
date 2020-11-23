<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Utils;

class UtilsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Utils::class, function ($app) {
            return new Utils();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Utils::class];
    }
}
