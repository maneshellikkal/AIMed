<?php

namespace App\Traits;

trait Publishable
{
    public function scopePublished($query)
    {
        if(auth()->check())
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