<?php

namespace App\Traits;

trait Featureable
{
    public function scopeFeatured($query, $condition = true)
    {
        return $query->whereFeatured($condition);
    }
}