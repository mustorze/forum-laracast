<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $mustorze = create('App\User', ['name' => 'Mustorze']);
        $henrique = create('App\User', ['name' => 'Henrique']);

        $this->signIn($mustorze);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
           'body' => '@Henrique Look at this!'
        ]);

        $this->json('POST', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $henrique->notifications);
    }
}
