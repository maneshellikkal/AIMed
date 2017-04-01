<?php

namespace App;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TwitterFeed extends Model
{
    use Filterable, Searchable;

    protected $guarded = [];

    protected $dates = ['twitter_timestamp'];

    protected $casts = [
        'tags' => 'array',
    ];

    public function toSearchableArray()
    {
        return array_only($this->toArray(), ['id', 'body', 'tags']);
    }
}
