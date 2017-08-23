<?php


namespace App;

use Illuminate\Support\Facades\Redis;

/**
 * Class Trending
 * @package App
 */
class Trending
{
    /**
     * @return static
     */
    public function get()
    {
        return collect(Redis::zrevrange($this->cacheKey(), 0, 4))
            ->map(function ($thread) {
                return json_decode($thread);
            });
    }

    /**
     * @param $thread
     */
    public function push($thread)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode($thread));
    }

    /**
     *
     */
    public function reset()
    {
        Redis::del($this->cacheKey());
    }

    /**
     * @return string
     */
    protected function cacheKey()
    {
        return app()->environment('testing') ? 'testing_trending_threads' : 'trending_threads';
    }
}