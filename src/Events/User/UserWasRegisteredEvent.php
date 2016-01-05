<?php

namespace Depotwarehouse\LadderTracker\Events\User;

use Depotwarehouse\Blumba\EventSourcing\SerializableEvent;
use Depotwarehouse\LadderTracker\Database\User\User;

class UserWasRegisteredEvent extends SerializableEvent
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
}
