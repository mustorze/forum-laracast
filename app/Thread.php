<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {

        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

    }

    public function path()
    {

        return url('/') . '/threads/' . $this->channel->slug . '/' . $this->id;

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {

        return $this->hasMany(Reply::class);

    }

    /**
     * @return mixed
     */
    public function getReplyCountAttribute()
    {

        return $this->replies()->count();

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {

        return $this->belongsTo(User::class, 'user_id');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @param $reply
     * @return mixed
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

    /**
     * @param $reply
     */
    public function notifySubscribers($reply)
    {
        $this->subscriptions
            ->where('user_id', '!=', $reply->user_id)
            ->each
            ->notify($reply);
    }

    /**
     * @param $query
     * @param $filters
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {

        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;

    }

    public function unsubscribe($userId = null)
    {

        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();

        return $this;

    }

    public function subscriptions()
    {

        return $this->hasMany(ThreadSubscription::class);

    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

}
