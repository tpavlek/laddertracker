<?php

namespace Depotwarehouse\LadderTracker\Events\Heroes;

use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use League\Event\AbstractEvent;

class HeroPointChangedEvent extends AbstractEvent implements SerializableEvent
{

    protected $user;
    protected $heroPointsToAdd;

    public function __construct(User $user, HeroPoints $heroPointsToAdd)
    {
        $this->user = $user;
        $this->heroPointsToAdd = $heroPointsToAdd;
    }

    public function difference()
    {
        return $this->heroPointsToAdd->getPoints();
    }

    public function getPayload()
    {
        return [
            'userId' => $this->user->getId()->toString(),
            'difference' => $this->difference()
        ];
    }

    public function getSerialzedPayload()
    {
        return json_encode($this->getPayload());
    }

    public function getAggregateId()
    {
        return $this->user->getId()->toString();
    }
}
