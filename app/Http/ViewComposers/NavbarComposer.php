<?php

namespace App\Http\ViewComposers;

use App\Repositories\ThemeRepository;
use Illuminate\View\View;

class NavbarComposer
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
        $view->with('themes' , ThemeRepository::getAllFirstLevelThemes());
        $view->with('menu_themes' , $this->getTree(ThemeRepository::getAllFirstLevelThemes()));

    }
    public function buildTree($items) {


//        $items2 = array(
//            array('id' => 42, 'parent_id' => 1),
//            array('id' => 43, 'parent_id' => 42),
//            array('id' => 1,  'parent_id' => 0),
//        );
//
//        $childs2 = array();
//        foreach($items2 as &$item2)
//        {
//            $childs2[$item2['parent_id']][] = &$item2;
////            var_dump($childs2);
//            unset($item2);
//
//        }
//
//        foreach($items2 as &$item2) {
//
//            if (isset($childs2[$item2['id']]))
//                $item2['childs'] = $childs2[$item2['id']];
////            unset($item2);
////            var_dump( $childs2[0]);
//
//        }
//
//        $tree = $childs2[0];
////        var_dump($tree);

        $childs = array();

        foreach($items as &$item)
        {
            $childs[intval($item->getThemeParent())][] = &$item;
        unset($item);
        }

        foreach($items as &$item)
        {
            if (isset($childs[$item->getId()])){
                $item->childs = $childs[$item->getId()];

            }
//            unset($item);
//            var_dump($childs[0]);

        }

//        var_dump($childs[0]);die;

        return $childs[0];
    }

    public function getTree($items)
    {
        $this->iteration_number++;
        $tree = "";
        foreach ($items as $theme) {
            $tree .= '<li class="level-'.$theme->getLevel().'">';
            $tree .= '<a href='.route('index.video',$theme->id).'>';
            $tree .= '<p>'.$theme->name.'</p>';
            if($theme->getLevel() == 0)
                $tree .= '<img src='.asset('/uploads/images/'. $theme->icon).'>';
            $tree .= '</a>';
            if (count($theme->getItems())) {
                $tree .= '<ul class="submenu" >';
                foreach ($theme->getItems() as $item) {
                    if (count($item->getItems())) {
                        $tree .= '<li class="level-'.$item->getLevel().' parent">';
                        $tree .= '<a href='.route('index.video',$item->getId()).'>';
                        $tree .= '<p>'.$item->getName().'</p>';
                        $tree .= '</a>';
                        $tree .= $this->getTree($item->getItems());;
                    } else {
                        $tree .= '<li class="level-'.$item->getLevel().'">';
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