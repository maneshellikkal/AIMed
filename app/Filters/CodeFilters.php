<?php

namespace App\Filters;

class CodeFilters extends QueryFilter
{
    public function show($value)
    {
        if(auth()->check() && $value == 'my')
        {
            return $this->builder->whereUserId(auth()->id());
        }
    }
}