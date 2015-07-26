<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Carbon\Carbon;
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
        $row = $this->userTable->where('id', '=', $event->getAggregateId());

        $row->increment('hero_points', $event->difference());
        $row->update([ 'hero_points_updated_at' => Carbon::now()->toDateTimeString() ]);
    }
}
