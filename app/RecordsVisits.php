<?php

namespace App;

use Illuminate\Support\Facades\Redis;

/**
 * Trait RecordsVisits
 * @package App
 */
trait RecordsVisits
{
    /**
     * @return $this
     */
    public function resetVisits()
    {
        Redis::del($this->visitsCacheKey());

        return $this;
    }

    /**
     * @return $this
     */
    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    /**
     * @return mixed
     */
    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?: 0;
    }

    /**
     * @return string
     */
    protected function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}