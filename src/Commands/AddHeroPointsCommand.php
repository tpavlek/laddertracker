<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Events\Heroes\HeroPointChangedEvent;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use League\Event\Emitter;

class AddHeroPointsCommand
{

    protected $emitter;

    public function __construct(Emitter $emitter)
    {
        $this->emitter = $emitter;
    }

    public function run(User $user, HeroPoints $pointsToAdd)
    {
        $this->emitter->emit(new HeroPointChangedEvent($user, $pointsToAdd));
    }

}
