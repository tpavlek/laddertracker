<?php

namespace Depotwarehouse\LadderTracker\Events;

use League\Event\EventInterface;

interface SerializableEvent extends EventInterface
{

    public function getPayload();

    public function getSerialzedPayload();

    public function getAggregateId();

}
