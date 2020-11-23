<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThemeVideo extends Pivot
{
    use SoftDeletes;


    protected $table = 'theme_video';
    protected $dateFormat = 'U';
    protected $fillable = ['order'];


}
