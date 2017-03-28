<?php

namespace App\Filters;

class DatasetFilters extends QueryFilter
{
    public function show ($value)
    {
        if ($value == 'featured') {
            return $this->builder->featured();
        }

        if (auth()->check() && $value == 'my') {
            return $this->builder->whereUserId(auth()->id());
        }
    }
}