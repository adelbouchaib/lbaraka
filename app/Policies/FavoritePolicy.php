<?php

namespace App\Policies;

use App\Models\User;

class FavoritePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(){
        return false;
    }

    public function create(){
        return false;
    }
}
