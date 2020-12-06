<?php

namespace App\Http\Controllers;

use App\Braker;
use App\Repositories\ThemeRepository;
use App\Services\VideoStream;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{

    public function __construct()
    {
        if (Config::get('parameters')['access']) {
            $this->middleware('auth');
        }
    }

    public function live()
    {
        return view('live');
    }

    public function index(Request $request)
    {
        if (Config::get('parameters')['access']) {
            $this->middleware('auth');
        }
        if (Config::get('parameters')['payment']) {
            $time = $request->user()->subscriptions()->orderBy('ends_at', 'desc')->first();
            if (!isset($time) || time() > strtotime($time->ends_at)) { // user not subscribed
                return redirect()->route('plans');
            }
        }
        $video = Braker::query()->first();
        return view('index', compact('video'));
    }

    /**
     * @param $themeId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function video(Request $request, $themeId)
    {
        if ($request->ajax()) {
            $videos = ThemeRepository::findVideosByThemeForHome($themeId);
            return $videos;
        }

        return view('page',['theme_id' => $themeId]);
    }

    /**
     * Find Video by id
     *
     * @param $videoId
     *
     * @return Video
     */
    public function show($videoId)
    {
        if (request()->ajax()) {
            $video = Video::findOrFail($videoId);
            return $video;
        }

        return view('page');
    }

    public function streamVideo($fileName)
    {
        $stream = new VideoStream(public_path('/uploads/videos/'.$fileName));
        return $stream->start();
    }

}
