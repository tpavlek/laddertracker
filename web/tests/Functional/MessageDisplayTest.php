<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Tests\Functional;

use Carbon\Carbon;
use Depotwarehouse\Blumba\Domain\DateTimeValue;
use Depotwarehouse\LadderTracker\Client\Web\Tests\TestCase;
use Depotwarehouse\LadderTracker\Database\MessageRecord;
use Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
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
     * @test
     */
    public function it_shows_most_recent_message_that_has_not_expired()
    {
        $yesterday = new DateTimeValue(Carbon::now()->subDay());
        $nextWeek = new DateTimeValue(Carbon::now()->addWeek());

        MessageRecord::createFrom(
            new Message("First message", $nextWeek),
            new Region(\Depotwarehouse\BattleNetSC2Api\Region::America)
        );

        MessageRecord::createFrom(
            new Message("Second Message", $yesterday),
            new Region(\Depotwarehouse\BattleNetSC2Api\Region::Europe)
        );

        $this->visit('/')
            ->dontSee("Second Message")
            ->see("First Message");
    }
}
