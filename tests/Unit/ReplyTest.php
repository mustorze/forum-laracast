<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{

    use DatabaseMigrations;

    public function test_it_has_a_owner() {

        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->owner);

    }

    /** @test */
    public function it_knows_if_it_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = create('App\Reply', [
           'body' => '@Mustorze wants to talk to @Henrique'
        ]);

        $this->assertEquals(['Mustorze', 'Henrique'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = create('App\Reply', [
            'body' => 'Hello @Mustorze'
        ]);

        $this->assertEquals(
           'Hello <a href="/profiles/Mustorze">@Mustorze</a>',
           $reply->body
        );
    }

    /** @test */
    function it_knows_if_it_is_the_best_reply()
    {
        $reply = create('App\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }

    /** @test */
    function a_reply_body_is_sanitized_automatically()
    {
        $reply = make('App\Reply', ['body' => '<script>alert("Bad")</script><p>this is okay</p>']);
        $this->assertEquals('<p>this is okay</p>', $reply->body);
    }
}
