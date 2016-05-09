<?php

namespace Depotwarehouse\LadderTracker\Tests\Database;

use Carbon\Carbon;
use Depotwarehouse\Blumba\Domain\DateTimeValue;
use Depotwarehouse\LadderTracker\Client\Web\Tests\TestCase;
use Depotwarehouse\LadderTracker\Database\MessageRecord;
use Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
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
        $nextWeek = new DateTimeValue(Carbon::now()->addWeek());

        MessageRecord::createFrom(
            new Message("First Message", $nextWeek),
            new Region(\Depotwarehouse\BattleNetSC2Api\Region::America)
        );

        // We want the second message to be from yestarday
        Carbon::setTestNow(Carbon::now()->subDay());

        MessageRecord::createFrom(
            new Message("Second Message", $nextWeek),
            new Region(\Depotwarehouse\BattleNetSC2Api\Region::Europe)
        );

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

        MessageRecord::createFrom(
            new Message("Some Message", new DateTimeValue(Carbon::now()->addWeeks(1))),
            new Region(\Depotwarehouse\BattleNetSC2Api\Region::America)
        );

        $messages = new MessageRecord();
        $messages->expireAll();

        $this->assertTrue($messages->latest()->isEmpty(), "The latest message should now be a null object");
    }

}
