<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\Request;

class ThreadsSubscriptionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'destroy']);
    }

    public function store($channelId, Thread $thread) {

        $thread->subscribe();

    }

    public function destroy($channelId, Thread $thread) {

        $thread->unsubscribe();

    }
}
