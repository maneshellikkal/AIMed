<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterFeed extends Model
{
    protected $guarded = [];

    protected $dates = ['twitter_timestamp'];

    protected $casts = [
        'tags' => 'array',
    ];
}
