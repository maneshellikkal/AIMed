<?php

namespace App;

use App\Traits\Featureable;
use App\Traits\Filterable;
use App\Traits\Ownable;
use App\Traits\Publishable;
use App\Traits\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Dataset extends Model implements HasMedia
{
    use Sluggable, SluggableScopeHelpers, HasMediaTrait;
    use Ownable, Featureable, Publishable, Filterable;

    protected $guarded = [];

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

    public function codes()
    {
        return $this->hasMany(Code::class);
    }
}