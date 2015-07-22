<?php

namespace Depotwarehouse\LadderTracker\Database\Contracts;

use Depotwarehouse\LadderTracker\Events\SerializableEvent;

interface Projector
{

    public function project(SerializableEvent $event);
}
