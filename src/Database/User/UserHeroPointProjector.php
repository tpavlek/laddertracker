<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Carbon\Carbon;
use Depotwarehouse\Blumba\ReadModel\Projector;
use Depotwarehouse\LadderTracker\Events\Heroes\HeroPointsChangedEvent;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Illuminate\Database\ConnectionInterface;

class UserHeroPointProjector extends Projector
{

    protected $userTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->userTable = $connection->table(UserRepository::USERS_TABLE_NAME);
    }

    public function projectHeroPointsChanged(HeroPointsChangedEvent $event)
    {
        $row = $this->userTable->where('id', '=', $event->getAggregateId());

        $row->increment('hero_points', $event->difference());
        $row->update([ 'hero_points_updated_at' => Carbon::now()->toDateTimeString() ]);
    }
}
