<?php

namespace App;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class TwitterFeed extends Model
{
    use Filterable;

    protected $guarded = [];

    protected $dates = ['twitter_timestamp'];

    protected $casts = [
        'tags' => 'array',
    ];
}
