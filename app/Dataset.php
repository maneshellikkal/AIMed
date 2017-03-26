<?php

namespace App;

use App\Filters\QueryFilter;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Dataset extends Model implements HasMedia
{
    use Sluggable, SluggableScopeHelpers, HasMediaTrait;

    protected $guarded = [];

    public function scopePublished($query, $condition = true)
    {
        return $query->wherePublished($condition);
    }

    public function scopeFeatured($query, $condition = true)
    {
        return $query->whereFeatured($condition);
    }

    public function scopeFilter($query, QueryFilter $filter)
    {
        return $filter->apply($query);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path()
    {
        return "/d/{$this->slug}";
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Return the sluggable configuration array for this model.
     * @return array
     */
    public function sluggable ()
    {
        return [
          'slug' => ['source' => 'name']
        ];
    }
}