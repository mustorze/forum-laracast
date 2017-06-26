<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function unthenticated_users_may_not_add_replies() {

        $this->withExceptionHandling()
        ->post(route('threads.replies.store', ['some-channel', 1]), [])
        ->assertRedirect('/login');

    }

    /** @test */
    public function an_authenticated_user_may_participated_in_forum_threads() {

        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
        ->assertSee($reply->body);

    }

    /** @test */
    public function a_reply_requires_a_body() {

        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertSessionHasErrors('body');;

    }

}
