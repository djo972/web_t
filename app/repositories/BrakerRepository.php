<?php

namespace App\Repositories;

use App\Braker;

class BrakerRepository
{

    private $braker;

    /**
     * BrakerRepository constructor.
     *
     * @param Braker $braker
     */
    public function __construct(Braker $braker)
    {
        $this->braker = $braker;
    }


    /**
     * create braker
     *
     * @param string $name
     * @param string $preview
     * @param string $videoFile
     * @param string $description
     * @param int $isShareable
     * @return bool
     */
    public static function create($name, $preview, $videoFile, $description, $isShareable)
    {
        $braker = new Braker();
        $braker->name = $name;
        $braker->preview = $preview;
        $braker->video_file = $videoFile;
        $braker->description = $description;
        $braker->is_shareable = $isShareable;

        $braker->save();

        return true;
    }

    /**
     * update braker
     *
     * @param string $name
     * @param string $preview
     * @param string $videoFile
     * @param string $description
     * @param int $isShareable
     * @return bool
     */
    public function update($name, $preview, $videoFile, $description, $isShareable)
    {
        if (isset($name)) {
            $this->braker->name = $name;
        }

        $this->braker->preview = $preview;

        if (isset($videoFile)) {
            $this->braker->video_file = $videoFile;
        }
        if (isset($description)) {
            $this->braker->description = $description;
        }
        if (isset($isShareable)) {
            $this->braker->is_shareable = $isShareable;
        }

        return $this->braker->save();
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
            $this->braker->delete();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

}