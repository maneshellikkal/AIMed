<?php

namespace App\Filters;

use App\User;
use Illuminate\Database\Eloquent\Builder;

class DatasetFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['featured', 'author'];

    /**
     * Show only featured datasets.
     *
     * @param $value
     *
     * @return Builder
     */
    public function featured($value)
    {
        return $this->builder->featured();
    }

    /**
     * Filter datasets by user.
     *
     * @param $username
     *
     * @return Builder
     */
    public function author($username)
    {
        $id = User::findByUsername($username, ['id'])->id ?? null;
        return $id ? $this->builder->whereUserId($id) : $this->builder;
    }
}