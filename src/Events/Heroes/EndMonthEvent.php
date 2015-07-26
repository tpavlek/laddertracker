<?php

namespace Depotwarehouse\LadderTracker\Events\Heroes;

use Depotwarehouse\LadderTracker\Database\Month\Month;
use Depotwarehouse\LadderTracker\Database\Month\MonthConstructor;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Illuminate\Support\Collection;
use League\Event\AbstractEvent;

class EndMonthEvent extends AbstractEvent implements SerializableEvent
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
