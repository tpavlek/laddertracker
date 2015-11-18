<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Database\MessageRecord;
use Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message;

class CreateMessageCommand
{

    protected $messages;

    public function __construct(MessageRecord $messages)
    {
        $this->messages = $messages;
    }

    public function run(Message $message)
    {
        $this->messages->create([
            'message' => $message->serialize(),
            'expires' => $message->expiry()->serialize()
        ]);
    }

}
