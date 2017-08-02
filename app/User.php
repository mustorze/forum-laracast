<?php

namespace App;

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
        'name', 'email', 'password',
    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() {

        return 'name';

    }

    /**
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function threads() {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity() {
        return $this->hasMany(Activity::class);
    }

    /**
     * @param $thread
     * @return string
     */
    public function visitedThreadCacheKey($thread) {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }

    public function read($model) {
        cache()->forever(
            $this->visitedThreadCacheKey($model),
            \Carbon\Carbon::now()
        );
    }

}
