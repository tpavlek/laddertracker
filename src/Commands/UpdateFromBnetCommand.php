<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Depotwarehouse\LadderTracker\Tracker;

class UpdateFromBnetCommand
{

    protected $tracker;

    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }

    public function run()
    {
        $this->tracker->updateAll();
    }

}
