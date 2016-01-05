<?php

namespace Depotwarehouse\LadderTracker\Events\Heroes;

use Depotwarehouse\Blumba\EventSourcing\SerializableEvent;
use Depotwarehouse\LadderTracker\Database\Month\Month;

class MonthWasEndedEvent extends SerializableEvent
{

    protected $month;

    public function __construct(Month $month)
    {
        $this->month = $month;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getPayload()
    {
        return $this->month->toArray();
    }

    public function getSerialzedPayload()
    {
        return json_encode($this->getPayload());
    }

    public function getAggregateId()
    {
        return $this->getMonth()->getId()->toString();
    }
}
