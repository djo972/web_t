<?php

namespace App\Repositories;

use App\Theme;
use App\Video;

class VideoRepository
{

    private $video;

    /**
     * videoRepository constructor.
     *
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * load all videos or all videos by theme and filtered the videos by name
     *
     * @param string $search
     * @return video[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function findVideos($search, $themeId)
    {

        if ($themeId != null) {
            if ($search != null) {
                $videos = Theme::where('id', '=', $themeId)->first()->videos()->where('name', 'like',
                    '%' . $search . '%')->paginate(10);
            } else {
                $videos = Theme::where('id', '=', $themeId)->first()->videos()->paginate(10);
            }
        } else {
            if ($search != null) {
                $videos = Video::where('name', 'like', '%' . $search . '%')->paginate(10);
            } else {
                $videos = Video::paginate(10);
            }
        }

        return $videos;
    }


    /**
     * get last video uploaded for page home front
     *
     * @return Video
     */
    public static function findLastVideo()
    {

        $video = Video::query()->where('is_visible', '=', 1)->latest()->first();

        return $video;
    }

    /**
     * create new video
     *
     * @param string $name
     * @param string $preview
     * @param string $videoFile
     * @param string $description
     * @param int $isVisible
     * @param int $isShareable
     * @param array $themes
     * @return bool
     */
    public static function create($name, $preview, $videoFile, $description, $isVisible, $isShareable, $themes)
    {
        $video = new Video();
        $video->name = $name;
        //$video->link = $link;
        $video->preview = $preview;
        $video->video_file = $videoFile;
        $video->description = $description;
        $video->is_visible = $isVisible;
        $video->is_shareable = $isShareable;

        $video->save();

        $video->themes()->sync($themes);

        return true;
    }

    /**
     * update video
     *
     * @param string $name
     * @param string $preview
     * @param string $videoFile
     * @param string $description
     * @param int $isVisible
     * @param int $isShareable
     * @param array $themes
     * @return bool
     */
    public function update($name, $preview, $videoFile, $description, $isVisible, $isShareable, $themes)
    {
        if (isset($name)) {
            $this->video->name = $name;
        }
        //$this->video->link = $link;
        $this->video->preview = $preview;

        if (isset($videoFile)) {
            $this->video->video_file = $videoFile;
        }
        if (isset($description)) {
            $this->video->description = $description;
        }
        if (isset($isShareable)) {
            $this->video->is_shareable = $isShareable;
        }
        if (isset($isVisible)) {
            $this->video->is_visible = $isVisible;
        }

        $this->video->themes()->sync($themes);
        return $this->video->save();
    }

    /**
     * enabled or disabled show video at home
     *
     * @return bool
     */
    public function showAtHome()
    {
        if ($this->video->is_visible == 1) {
            $this->video->is_visible = 0;
        } else {
            $this->video->is_visible = 1;
        }

        return $this->video->save();
    }

    /**
     * enable or disabled show share links at home
     *
     * @return bool
     */
    public function showShareLinks()
    {
        if ($this->video->is_shareable == 1) {
            $this->video->is_shareable = 0;
        } else {
            $this->video->is_shareable = 1;
        }

        return $this->video->save();
    }

    /**
     * soft delete video
     *
     * @return bool
     */
    public function delete()
    {
        try {
            $this->video->delete();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * update sort videos by theme
     *
     * @param array $listOrders
     *
     * @param int $themeId
     */
    public static function updateOrder($listOrders, $themeId)
    {
        foreach ($listOrders as $k => $v) {
            Video::findOrFail($v)->themes()->updateExistingPivot($themeId, ['order' => $k]);
        }
    }

}