<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function it_record_activity_when_thread_is_created()
    {

        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type'  =>  'created_thread',
            'user_id'   =>  auth()->id(),
            'subject_id'    =>  $thread->id,
            'subject_type'  =>  'App\Thread'
        ]);

        $this->assertEquals($activity->subject->id, $thread->id);

    }
}
