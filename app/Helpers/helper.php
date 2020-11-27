<?php

namespace App\Helpers;

use App\Repositories\ThemeRepository;

/**
 * upload image to /storage/images folder and return the name of image
 *
 * @param string $file
 * @return string
 */
function uploadImage($file)
{
    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
    $destinationPath = public_path('/uploads/images');
    $file->move($destinationPath, $fileName);

    return $fileName;
}

/**
 * find image by name and remove it
 *
 * @param string $fileName
 *
 * @return bool
 */
function removeImage($fileName)
{
    if ($fileName) {
        $directory = public_path('/uploads/images');
        $file = $directory . '/' . $fileName;
        if (file_exists($file) && is_file($file)) {
            unlink($file);
        }
    }

    return true;
}

/**
 * find video by name and remove it
 *
 * @param string $fileName
 *
 * @return bool
 */
function removeVideo($fileName)
{
    if ($fileName) {
        $directory = public_path('/uploads/videos');
        $file = $directory . '/' . $fileName;
        if (file_exists($file) && is_file($file)) {
            unlink($file);
        }
    }

    return true;
}


function getThemeLevel($themeId){

    $level = 0;
    if($themeId !== null ) {
        $theme = ThemeRepository::load($themeId);
        if ($theme->getId()) {
            $level = $theme->getLevel() + 1;
        }
    }

    return $level;
}

