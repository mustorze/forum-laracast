<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();
        $this->signIn();
    }

    /** @test */
    function a_thread_requires_a_title_and_body_to_be_updated()
    {
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'Changed',
        ])->assertSessionHasErrors('body');

        $this->patch($thread->path(), [
            'body' => 'Changed',
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_can_be_updated_by_its_creator()
    {
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patchJson($thread->path(), [
            'title' => 'Changed',
            'body' => 'Changed body.'
        ]);

        $this->assertEquals('Changed', $thread->fresh()->title);
        $this->assertEquals('Changed body.', $thread->fresh()->body);
    }

    /** @test */
    function unauthorized_users_may_not_update_threads()
    {
        $thread = create('App\Thread', ['user_id' => create('App\User')->id]);

        $this->patchJson($thread->path(), [])->assertStatus(403);
    }
}