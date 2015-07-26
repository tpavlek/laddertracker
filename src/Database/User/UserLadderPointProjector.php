<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\LadderTracker\Database\Contracts\Projector;
use Depotwarehouse\LadderTracker\Events\Ladder\PointChangedEvent;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Illuminate\Database\ConnectionInterface;

class UserLadderPointProjector implements Projector
{

    protected $userTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->userTable = $connection->table(UserRepository::USERS_TABLE_NAME);
    }

    public function project(SerializableEvent $event)
    {
        if (!$event instanceof PointChangedEvent) {
            throw new \InvalidArgumentException("UserLadderPointProjector is not aware of how to project event of type: {$event->getName()}");
        }

        if (!$this->thereIsADifference($event)) { return; }
        $this->userTable->where('id', '=', $event->getPayload()['userId'])->increment('ladder_points', $event->getPayload()['difference']);
    }

    /**
     * In the case where this projector has received an event that contains no difference, then the event was in error,
     * and we do not wish to record it.
     *
     * @param PointChangedEvent $event
     * @return bool
     */
    protected function thereIsADifference(PointChangedEvent $event)
    {
        return ($event->difference() !== 0);
    }
}
