<?php

namespace App;

use App\Traits\Filterable;
use App\Traits\Votable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TwitterFeed extends Model
{
    use Filterable, Searchable, Votable;

    protected $guarded = [];

    protected $dates = ['twitter_timestamp'];

    protected $casts = [
        'tags' => 'array',
    ];

    public function toSearchableArray()
    {
        return array_only($this->toArray(), ['id', 'body', 'tags']);
    }

    /**
     * Get a string path for the news.
     *
     * @return string
     */
    public function path ()
    {
        return "/news/{$this->id}";
    }
}
