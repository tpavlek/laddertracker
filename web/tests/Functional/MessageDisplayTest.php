<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Tests\Functional;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Client\Web\Tests\TestCase;
use Depotwarehouse\LadderTracker\Database\MessageRecord;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MessageDisplayTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     *
     * @test
     */
    public function it_shows_most_recent_message_that_has_not_expired()
    {
        $today = Carbon::now()->toDateTimeString();
        $yesterday = Carbon::now()->subDay()->toDateTimeString();
        $nextWeek = Carbon::now()->addWeek()->toDateTimeString();

        MessageRecord::create([
            'message' => "First Message",
            'created_at' => $yesterday,
            'updated_at' => $today,
            'expires' => $nextWeek
        ]);
        MessageRecord::create([
            'message' => 'Second Message',
            'created_at' => $yesterday,
            'updated_at' => $yesterday,
            'expires' => $nextWeek
        ]);

        $this->visit('/')
            ->dontSee("Second Message")
            ->see("First Message");
    }

    /*public function test_it_will_not_show_a_message_that_has_expired()
    {

    }*/

}
