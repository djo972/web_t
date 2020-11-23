<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Braker extends Model
{

    use SoftDeletes;

    protected $dateFormat = 'U';
    protected $fillable = [];


}
