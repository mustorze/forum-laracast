<?php

namespace App;

trait RecordsActivity {

    protected static function bootRecordsActivity() {

        static::created(function ($thread) {
            $thread->recordActivity('created');
        });

    }

    public function recordActivity($event) {

        $this->activity()->create([
            'user_id'   =>  auth()->id(),
            'type'  =>  $this->getActivityType($event)
        ]);

    }

    public function activity() {
        return $this->morphMany('App\Activity', 'subject');
    }


    public function getActivityType($event) {

        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }

}
