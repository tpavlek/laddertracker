<?php

namespace Depotwarehouse\LadderTracker\Tests;

use Depotwarehouse\Blumba\EventSourcing\SerializableEvent;
use Depotwarehouse\LadderTracker\Client\Web\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use League\Event\Emitter;

class ScenarioTest extends TestCase
{

    use DatabaseTransactions;

    public function scenario(SerializableEvent ...$events)
    {
        $emitter = $this->app->make(Emitter::class);

        collect($events)
            ->each(function ($event) use ($emitter) {
                $emitter->emit($event);
            });
    }
}
