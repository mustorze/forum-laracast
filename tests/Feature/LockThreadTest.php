<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LockThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function non_administrators_may_not_lock_threads()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->postJson(route('locked-threads.store', $thread))->assertStatus(403);

        $this->assertFalse(!!$thread->fresh()->locked);
    }

    /** @test */
    public function once_lock_a_thread_may_not_receive_new_replies()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $thread->update(['locked' => true]);

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }

    /** @test */
    function administrator_can_lock_threads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->postJson(route('locked-threads.store', $thread))
            ->assertStatus(200);

        $this->assertTrue($thread->fresh()->locked);
    }

    /** @test */
    function administrator_can_unlock_threads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id(), 'locked' => false]);

        $this->deleteJson(route('locked-threads.destroy', $thread))
            ->assertStatus(200);

        $this->assertFalse($thread->fresh()->locked);
    }
}