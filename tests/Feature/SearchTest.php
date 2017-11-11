<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_search_threads()
    {
        config(['scout.driver' => 'algolia']);

        $search = 'foobar';
        create('App\Thread', [], 2);
        $desiredThreads = create('App\Thread', ['body' => "A thread with {$search} term."], 2);

        do {
            sleep(.25);

            $results = $this->getJson("/threads/search?query={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(2, $results);

        $desiredThreads->unsearchable();
    }
}
