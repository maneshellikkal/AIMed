<?php

namespace App\Traits;

trait Publishable
{
    public function scopePublished($query, $force = false)
    {
        if(auth()->check() && $force)
        {
            return $query->wherePublished(true)
                         ->orWhere(function($query){
                            $query->whereUserId(auth()->id());
                            $query->wherePublished(false);
                        });
        }

        return $query->wherePublished(true);
    }
}