<?php

namespace App\Http\Controllers;

use App\Thread;

/**
 * Class ThreadsSubscriptionsController
 * @package App\Http\Controllers
 */
class ThreadsSubscriptionsController extends Controller
{
    /**
     * ThreadsSubscriptionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'destroy']);
    }

    /**
     * @param $channelId
     * @param Thread $thread
     */
    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }

    /**
     * @param $channelId
     * @param Thread $thread
     */
    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
