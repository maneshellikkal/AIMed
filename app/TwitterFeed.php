<?php

namespace App;

use App\Traits\Filterable;
use App\Traits\Votable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TwitterFeed extends Model
{
    use Filterable, Searchable, Votable;

    protected $guarded = [];

    protected $hidden = ['data'];

    protected $dates = ['twitter_timestamp'];

    protected $casts = [
        'tags' => 'array',
    ];

    public function toSearchableArray()
    {
        return array_only($this->toArray(), ['id', 'body', 'tags']);
    }

    /**
     * Scope for trending news.
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeTrending(Builder $query)
    {
        return $query->withCount('votes')
                      ->where('created_at', '>', Carbon::parse('-7  days'))
                      ->orderByDesc('votes_count');
    }

    /**
     * Scope for popular news.
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopePopular(Builder $query)
    {
        return $query->withCount('votes')
                             ->orderByDesc('votes_count');
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
