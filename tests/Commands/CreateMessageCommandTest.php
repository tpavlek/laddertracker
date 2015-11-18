<?php

namespace Depotwarehouse\LadderTracker\Tests\Commands;

use Depotwarehouse\Blumba\Domain\DateTimeValue;
use Depotwarehouse\LadderTracker\Client\Web\Tests\TestCase;
use Depotwarehouse\LadderTracker\Commands\CreateMessageCommand;
use Depotwarehouse\LadderTracker\Database\MessageRecord;
use Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateMessageCommandTest extends TestCase
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
    public function it_saves_message_to_database()
    {
        $now = DateTimeValue::now();
        $message = new Message("Message in database paradise", $now);

        $createCommand = new CreateMessageCommand(new MessageRecord());

        $createCommand->run($message);

        $this->seeInDatabase('messages', [ 'message' => "Message in database paradise", 'expires' => $now->getDateTime()->toDateTimeString() ]);
    }

}
