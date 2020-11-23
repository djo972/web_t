<?php

namespace App\Repositories;

use App\User;

class UserRepository
{

    private $user;


    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }



}