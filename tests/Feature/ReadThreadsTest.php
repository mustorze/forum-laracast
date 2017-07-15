<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_browse_all_threads()
    {

        $this->get(route('threads'))
        ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_browse_single_thread()
    {

        $this->get($this->thread->path())
        ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');

        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get(route('threads.channel.show', $channel->slug))
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {

        $this->signIn(create('App\User', ['name' => 'Henrique']));

        $threadByHenrique = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByHenrique = create('App\Thread');

        $this->get(route('threads.by', 'Henrique'))
            ->assertSee($threadByHenrique->title)
            ->assertDontSee($threadNotByHenrique->title);

    }


    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {

        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson(url('/') . '/threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));

    }

    /** @test */
    public function a_user_can_filter_threads_by_those_that_are_unanswered() {

        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson(url('/') . '/threads?unanswered=1')->json();

        $this->assertCount(1, $response);

    }

    /** @test */
    public function a_user_can_request_all_replies_for_a_given_thread() {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 2);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }
}
