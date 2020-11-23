<?php

namespace App\Http\ViewComposers;

use App\Repositories\ThemeRepository;
use Illuminate\View\View;

class NavbarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('themes' , ThemeRepository::getAllThemes());

    }
}