<?php

namespace App\Filters;

use App\User;
use Illuminate\Database\Eloquent\Builder;

class CodeFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['user'];

    /**
     * Filter code by user.
     *
     * @param $username
     *
     * @return Builder
     */
    public function user($username)
    {
        $id = User::findByUsername($username, ['id'])->id ?? null;
        return $id ? $this->builder->whereUserId($id) : $this->builder;
    }
}