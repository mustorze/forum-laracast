<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;

/**
 * Class NotifyThreadSubscribers
 * @package App\Listeners
 */
class NotifyThreadSubscribers
{
    /**
     * Handle the event.
     *
     * @param  ThreadHasNewReply $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        $event->thread->notifySubscribers($event->reply);
    }
}
