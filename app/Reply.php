<?php

namespace App;

use App\Traits\Ownable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Ownable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * A reply belongs to a thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}