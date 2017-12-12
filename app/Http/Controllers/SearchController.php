<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Trending;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        if (request()->expectsJson()) {
            $threads = Thread::search(request('query'))
                ->paginate(25);

            return $threads;
        }

        return view('threads.search', [
            'trending' => $trending->get()
        ]);
    }
}
