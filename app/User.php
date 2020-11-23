<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Billable;
    use SoftDeletes;

    const GENDER_FEMALE = 1;
    const GENDER_MALE = 2;

    protected $dateFormat = 'U';

    protected $fillable = ['login', 'password', 'email', 'type'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * magic field name that combines the first_name and the last_name with a space in between
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }
}
