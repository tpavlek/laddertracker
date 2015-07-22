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

    public function getPayload()
    {
        return [
            'id' => (string)$this->user->getId(),
            'display_name' => (string)$this->user->getDisplayName(),
            'bnet_id' => $this->user->getBnetId()->getId(),
            'bnet_url' => (string)$this->user->getBnetUrl(),
            'ladder_rank' => $this->user->getRank()->getLadderRank(),
            'ladder_points' => $this->user->getRank()->getLadderPoints()
        ];
    }

    public function getSerialzedPayload()
    {
        return json_encode($this->getPayload());
    }
}
