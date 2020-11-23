<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use SoftDeletes;

    const MAX_THEME = 15;
    protected $dateFormat = 'U';
    protected $fillable = [];

    /**
     * The videos that belong to the theme.
     */
    public function videos()
    {
        return $this
            ->belongsToMany(Video::class, 'theme_video')
            ->using(ThemeVideo::class)
            ->as('themeVideo')
            ->withPivot('order')
            ->orderBy('theme_video.order', 'asc');

    }


}
