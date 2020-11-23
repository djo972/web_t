<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'U';
    protected $fillable = [];
    /**
     * The themes that belong to the video.
     */
    public function themes()
    {
        return $this
            ->belongsToMany(Theme::class, 'theme_video')
            ->using(ThemeVideo::class)
            ->as('themeVideo')
            ->withPivot('order')
            ->orderBy('theme_video.order', 'asc');
    }

}
