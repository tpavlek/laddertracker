<?php

namespace Depotwarehouse\LadderTracker\Events\User;

use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use League\Event\AbstractEvent;

class UserWasRegisteredEvent extends AbstractEvent implements SerializableEvent
{

    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function getAggregateId()
    {
        return (string)$this->getUser()->getId();
    }


    public function getUser()
    {
        return $this->user;
    }

    public function getPayload()
    {
        return $this->getUser()->toArray();
    }

    public function getSerialzedPayload()
    {
        return json_encode($this->getPayload());
    }
}
