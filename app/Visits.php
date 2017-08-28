<?php


namespace App;

use Illuminate\Support\Facades\Redis;

/**
 * Class Visits
 * @package App
 */
class Visits
{
    protected $model;

    /**
     * Visits constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        Redis::del($this->cacheKey());

        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return Redis::get($this->cacheKey()) ?: 0;
    }

    /**
     * @return $this
     */
    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    /**
     * @return string
     */
    protected function cacheKey()
    {
        return class_basename($this->model) . ".{$this->model->id}.visits";
    }
}