<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Database\MessageRecord;
use Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message;
use Depotwarehouse\LadderTracker\ValueObjects\Region;

class CreateMessageCommand
{

    protected $messages;

    public function __construct(MessageRecord $messages)
    {
        $this->messages = $messages;
    }

    public function run(Message $message, Region $region)
    {
        $this->messages->createFrom($message, $region);
    }
}
