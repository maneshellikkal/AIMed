<?php

namespace App\Traits;

use App\User;

trait Ownable
{
    public function isOwnedBy(User $user) : bool
    {
        return $this->user_id == $user->id;
    }
}