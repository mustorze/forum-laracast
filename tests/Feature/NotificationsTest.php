<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_recives_a_reply_that_is_not_by_current_user() {

        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id'   =>  auth()->id(),
            'body'  =>  'Some Reply Here!'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id'   =>  create('App\User')->id,
            'body'  =>  'Some Reply Here!'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);

    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications() {

        create(DatabaseNotification::class);

        $user = auth()->user();

        $response = $this->getJson(url('/') . '/profiles/' . auth()->user()->name . '/notifications')->json();

        $this->assertCount(1, $response);

    }

    /** @test */
    public function a_user_can_clear_notification() {

        create(DatabaseNotification::class);

        tap(auth()->user(), function ($user) {

            $this->assertCount(1, $user->fresh()->unreadNotifications);

            $notificationId = $user->unreadNotifications->first()->id;

            $this->delete(url('/') . '/profiles/' . $user->name . '/notifications/' . $notificationId);

            $this->assertCount(0, $user->fresh()->unreadNotifications);

        });

    }

}
