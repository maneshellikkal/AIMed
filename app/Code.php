<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Code extends Model
{
    use Sluggable, SluggableScopeHelpers;
    protected $guarded = [];

    public function path ()
    {
        return "/c/{$this->slug}";
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dataset ()
    {
        return $this->belongsTo(Dataset::class);
    }
}
