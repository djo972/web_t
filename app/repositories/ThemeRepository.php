<?php

namespace App\Repositories;

use App\Theme;

class ThemeRepository
{

    private $theme;


    /**
     * ThemeRepository constructor.
     *
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * get all themes visible in front office
     *
     * @return Theme
     */
    public static function getAllThemes()
    {
        $themes = Theme::where('is_visible', '=', 1)->orderBy('order', 'asc')->limit(Theme::MAX_THEME)->get();

        return $themes;
    }

    /**
     * find all themes or find themes by name
     *
     * @param string $search
     *
     * @return Theme[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function findThemes($search)
    {
        if ($search != null) {
            $themes = Theme::where('name', 'like', '%' . $search . '%')->orderBy('order', 'asc')->get();
        } else {
            $themes = Theme::orderBy('order', 'asc')->get();
        }

        return $themes;
    }


    /**
     * get videos by theme id For Front
     *
     * @param int $themeId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function findVideosByThemeForHome($themeId)
    {
        $theme = Theme::where('id', '=', $themeId)->first()->videos()->where('is_visible', '=', 1)->paginate(10);

        return $theme;
    }

    /**
     * create new theme
     *
     * @param string $name
     * @param string $icon
     * @param int $isVisible
     *
     * @return bool
     */
    public static function create($name, $icon, $isVisible)
    {
        $theme = new Theme();
        $theme->name = $name;
        $theme->icon = $icon;
        $theme->is_visible = $isVisible;

        return $theme->save();
    }

    /**
     * update theme
     *
     * @param string $name
     * @param string $icon
     * @param int
     *
     * @return bool
     */
    public function update($name, $icon, $isVisible)
    {
        if (isset($name)) {
            $this->theme->name = $name;
        }
        if (isset($icon)) {
            $this->theme->icon = $icon;
        }
        if (isset($isVisible)) {
            $this->theme->is_visible = $isVisible;
        }

        return $this->theme->save();
    }

    /**
     * enabled or disabled show theme at home
     *
     * @param int $enabled
     * @return bool
     */
    public function showAtHome($enabled)
    {
        if ($enabled == false) {
            $this->theme->is_visible = false;
        } else {
            $this->theme->is_visible = true;
        }

        return $this->theme->save();
    }

    /**
     * soft delete theme
     *
     * @return bool
     */
    public function delete()
    {
        try {
            $this->theme->delete();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * update sort theme
     *
     * @param array $listOrders
     *
     * @return bool
     */
    public static function updateOrder($listOrders)
    {
        foreach ($listOrders as $k => $v) {
            $theme = Theme::findOrFail($v);
            $theme->order = $k;
            $theme->save();
        }
        return true;
    }

    /**
     * get total of visible Theme
     *
     * @param int $explodeId
     * @return mixed
     */
    public static function totalVisibleTheme($explodeId = null)
    {
        $theme =  Theme::where('is_visible', '=', 1);

        if($explodeId) {
            $theme->where('id', '<>', $explodeId);
        }
        return $theme->count();
    }

}