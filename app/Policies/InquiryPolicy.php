<?php

namespace App\Policies;

use App\Models\User;

class InquiryPolicy
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

    public function delete(){
        return false;
    }

    public function deleteAny(){
        return false;
    }


}
