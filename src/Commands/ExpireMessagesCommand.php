<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Depotwarehouse\LadderTracker\Database\MessageRecord;

class ExpireMessagesCommand
{

    protected $messages;

    public function __construct(MessageRecord $messages)
    {
        $this->messages = $messages;
    }

    public function run()
    {
        $this->messages->expireAll();
    }

}
