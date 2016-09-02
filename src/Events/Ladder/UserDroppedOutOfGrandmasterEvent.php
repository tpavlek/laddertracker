<?php

namespace Depotwarehouse\LadderTracker\Events\Ladder;

use Depotwarehouse\Blumba\EventSourcing\SerializableEvent;
use Depotwarehouse\LadderTracker\Database\User\User;

class UserDroppedOutOfGrandmasterEvent extends SerializableEvent
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getAggregateId()
    {
        return $this->user->getId()->serialize();
    }
}
