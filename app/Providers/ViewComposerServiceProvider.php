<?php

namespace App\Providers;

use App\Http\ViewComposers\NavbarComposer;
use App\Http\ViewComposers\SidebarComposer;
use App\Http\ViewComposers\NavComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.navbar', NavbarComposer::class);
        View::composer('layouts.sidebar', SidebarComposer::class);
        View::composer('layouts.nav', NavComposer::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
