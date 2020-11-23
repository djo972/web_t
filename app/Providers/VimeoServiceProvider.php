<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\VimeoVideo;
use Vimeo\Vimeo;

class VimeoServiceProvider extends ServiceProvider
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
        $this->app->singleton(Vimeo::class, function ($app) {
            return new Vimeo(config('vimeo.id'), config('vimeo.secret'), config('vimeo.token'));
        });
        
        $this->app->singleton(VimeoVideo::class, function ($app) {
            return new VimeoVideo();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Vimeo::class, VimeoVideo::class];
    }
}
