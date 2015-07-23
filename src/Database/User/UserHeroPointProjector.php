<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\LadderTracker\Database\Contracts\Projector;
use Depotwarehouse\LadderTracker\Events\Heroes\HeroPointChangedEvent;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Illuminate\Database\ConnectionInterface;

class UserHeroPointProjector implements Projector
{

    protected $userTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->userTable = $connection->table(UserRepository::USERS_TABLE_NAME);
    }

    public function project(SerializableEvent $event)
    {
        /** @var HeroPointChangedEvent $event */
        $this->userTable->where('id', '=', $event->getAggregateId())->increment('hero_points', $event->difference());
    }
}
