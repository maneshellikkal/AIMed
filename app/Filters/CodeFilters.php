<?php

namespace App\Filters;

class CodeFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['show'];

    /**
     * @param $value
     *
     * @return mixed
     */
    public function show ($value)
    {
        if (auth()->check() && $value == 'my') {
            return $this->builder->whereUserId(auth()->id());
        }
    }
}