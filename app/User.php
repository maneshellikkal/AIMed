<?php

namespace App;

use Facades\App\Helpers\Gravatar;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'gravatar'
    ];

    public function getGravatarAttribute()
    {
        return Gravatar::src($this->email);
    }

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path()
    {
        return "/u/{$this->username}";
    }

    /**
     * A User may have multiple datasets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function datasets()
    {
        return $this->hasMany(Dataset::class);
    }

    public function codes()
    {
        return $this->hasMany(Code::class);
    }
}
