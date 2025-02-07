<?php

namespace App\Policies;

use App\Models\User;

class RequestPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->role !== 'seller';
    }

    public function update(User $user)
    {
        return $user->role !== 'seller';
    }
}
