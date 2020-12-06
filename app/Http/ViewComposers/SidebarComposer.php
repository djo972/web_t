<?php

namespace App\Http\ViewComposers;

use App\Repositories\ThemeRepository;
use App\Theme;
use Illuminate\View\View;

class SidebarComposer
{
    private $iteration_number = 0;

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sidebar_menu_themes' , $this->getTree(ThemeRepository::findThemesByParent($view->getData()['theme_id'])));

    }

    public function getTree($items)
    {
        $this->iteration_number++;
        $tree = "";
        /** @var Theme $theme */
        foreach ($items as $theme) {
            $tree .= '<li class="level-'.$theme->getLevel().' '.$theme->getClassCss().'">';
            $tree .= '<a href='.route('index.video',$theme->getId()).'>';
            $tree .= '<p>'.$theme->name.'</p>';
            if($theme->getLevel() == 0)
                $tree .= '<img src='.asset('/uploads/images/'. $theme->getIcon()).'>';
            $tree .= '</a>';
            if (count($theme->getItems())) {
                $tree .= '<ul class="submenu" >';
                /** @var Theme $item */
                foreach ($theme->getItems() as $item) {
                    if (count($item->getItems())) {
                        $tree .= '<li class="level-'.$item->getLevel().' parent '.$item->getClassCss().'">';
                        $tree .= '<a href='.route('index.video',$item->getId()).'>';
                        $tree .= '<p>'.$item->getName().'</p>';
                        $tree .= '</a>';
                        $tree .= $this->getTree($item->getItems());;
                    } else {
                        $tree .= '<li class="level-'.$item->getLevel().' '.$item->getClassCss().'">';
                        $tree .= '<a href='.route('index.video',$item->getId()).'>';
                        $tree .= '<p>'.$item->getName().'<p>';
                        $tree .= '</a>';
                    }
                    $tree .= '</li>';
                }
                $tree .= '</ul>';
            }
        }
        return $tree;
    }

}