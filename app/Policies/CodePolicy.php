<?php

namespace App\Policies;

use App\User;
use App\Code;
use Illuminate\Auth\Access\HandlesAuthorization;

class CodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the code.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function view(User $user, Code $code)
    {
        //
    }

    /**
     * Determine whether the user can create codes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the code.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function update(User $user, Code $code)
    {
        //
    }

    /**
     * Determine whether the user can delete the code.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function delete(User $user, Code $code)
    {
        //
    }
}
