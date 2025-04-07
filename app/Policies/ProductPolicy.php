<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->role === 'sadmin';
    }

    public function deleteAny(User $user): bool
    {
        return $user->role === 'sadmin';
    }
}