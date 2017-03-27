<?php

namespace App;

use App\Traits\Filterable;
use App\Traits\Ownable;
use App\Traits\Publishable;
use App\Traits\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use Sluggable, SluggableScopeHelpers;
    use Ownable, Publishable, Filterable;

    protected $guarded = [];

    public function path ()
    {
        return "/c/{$this->slug}";
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
