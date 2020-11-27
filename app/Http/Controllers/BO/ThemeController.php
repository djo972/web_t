<?php

namespace App\Http\Controllers\BO;

use function App\Helpers\getThemeLevel;
use function App\Helpers\removeImage;
use function App\Helpers\uploadImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Repositories\ThemeRepository;
use App\Theme;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * index for Theme model
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search', null);
            return response()->json(ThemeRepository::findThemes($search));
        }

        return view('bo.theme.index');
    }

    /**
     * get list of themes
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listThemes(Request $request)
    {
        if ($request->ajax()) {
            $themes = Theme::all();
            return response()->json($themes, 200);
        }

        return view('bo.theme.index');
    }


    /**
     * Find Theme by id
     *
     * @param int $themeId
     * @return Theme
     */
    public function show($themeId)
    {
        $theme = Theme::findOrFail($themeId);
        return $theme;
    }

    /**
     * Create new Theme
     *
     * @param CreateThemeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateThemeRequest $request)
    {
        $name = $request->input('name');
        $isVisible = $request->input('is_visible', 0);
        $icon = $request->file('icon');
        $parentTheme = $request->input('theme_parent');
        if ((ThemeRepository::totalVisibleTheme() < Theme::MAX_THEME && $isVisible == true) || ($isVisible == 0)) {
            $level = getThemeLevel($parentTheme);
            $icon = uploadImage($icon);
            ThemeRepository::create($name, $icon, $isVisible, $parentTheme, $level);
            return response()->json(["message" => 'CREATE_SUCCESS'], 201);
        } else {
            return response()->json(["error" => 'MENU_SATURATED'], 422);
        }
    }

    /**
     * Update theme
     *
     * @param UpdateThemeRequest $request
     * @param int $themeId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateThemeRequest $request, $themeId)
    {
        $name = $request->input('name');
        $theme = Theme::findOrFail($themeId);
        $isVisible = $request->input('is_visible', 0);

        if (ThemeRepository::totalVisibleTheme($themeId) < Theme::MAX_THEME) {
            if ($request->hasFile('icon')) {
                $icon = $request->file('icon');
                removeImage($icon);
                $icon = uploadImage($icon);
            } else {
                $icon = $theme->icon;
            }

            $themeRepository = new ThemeRepository($theme);
            $themeRepository->update($name, $icon, $isVisible);

            return response()->json(["message" => 'UPDATE_SUCCESS'], 200);
        } else {
            return response()->json(["error" => 'MENU_SATURATED'], 422);
        }

    }

    /**
     * Enable and Disable show theme in front office
     *
     * @param int $themeId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAtHome(Request $request, $themeId)
    {
        $theme = Theme::findOrFail($themeId);
        $enabled = $request->get('enabled');
        $themeRepository = new ThemeRepository($theme);

        if (ThemeRepository::totalVisibleTheme($themeId) < Theme::MAX_THEME) {
            if ($enabled == 0) {
                $message = 'IS_DISABLED';
            } else {
                $message = 'IS_ENABLED';
            }
            $themeRepository->showAtHome($enabled);
            return response()->json(["message" => $message], 200);
        } else {
            return response()->json(["error" => 'MENU_SATURATED'], 422);
        }

    }

    /**
     * Delete theme softly
     *
     * @param int $themeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($themeId)
    {
        $theme = Theme::findOrFail($themeId);
        if ($theme->videos()->count() == 0 ) {
            removeImage($theme->icon);
            $theme->videos()->detach();
            $themeRepository = new ThemeRepository($theme);
            $themeRepository->delete();
            return response()->json(["message" => 'DELETE_SUCCESS'], 200);
        } else {
            return response()->json(["message" => 'HAS_VIDEO'], 422);
        }
    }


    /**
     * Sort themes by drag and drop
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sortThemes(Request $request)
    {
        if (request()->ajax()) {
            $orderArray = $request->get('orderArray');
            ThemeRepository::updateOrder($orderArray);
            return response()->json(["message" => 'UPDATE_ORDER_SUCCESS'], 200);
        }

    }


}
