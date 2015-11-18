<?php

namespace Depotwarehouse\LadderTracker\Tests\Database;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Client\Web\Tests\TestCase;
use Depotwarehouse\LadderTracker\Database\MessageRecord;
use Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MessageRecordTest extends TestCase
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
     * @test
     */
    public function it_retrieves_the_latest_message_that_is_not_expired()
    {
        $today = Carbon::now()->toDateTimeString();
        $yesterday = Carbon::now()->subDay()->toDateTimeString();
        $nextWeek = Carbon::now()->addWeek()->toDateTimeString();

        MessageRecord::unguard();

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

        $messages = new MessageRecord();
        $message = $messages->latest();

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals("First Message", (string)$message);
    }

    /**
     * @test
     */
    public function it_can_expire_all_messages()
    {
        MessageRecord::unguard();
        MessageRecord::create([
            'message' => 'Some Message',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
            'expires' => Carbon::now()->addWeeks(1)
        ]);

        $messages = new MessageRecord();
        $messages->expireAll();

        $this->assertTrue($messages->latest()->isEmpty(), "The latest message should now be a null object");
    }

}
