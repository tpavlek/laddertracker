<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\Blumba\ReadModel\Projector;
use Depotwarehouse\LadderTracker\Events\Ladder\PointsChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\UserDroppedOutOfGrandmasterEvent;
use Illuminate\Database\ConnectionInterface;

class UserLadderPointProjector extends Projector
{

    protected $userTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->userTable = $connection->table(UserRepository::USERS_TABLE_NAME);
    }

    public function projectPointsChanged(PointsChangedEvent $event)
    {
        if (!$this->thereIsADifference($event)) {
            return;
        }
        $this->userTable->where('id', '=', $event->getPayload()['userId'])->increment('ladder_points', $event->getPayload()['difference']);
    }

    public function projectUserDroppedOutOfGrandmaster(UserDroppedOutOfGrandmasterEvent $event)
    {
        $this->userTable->where('id', '=', $event->getUser()->getId()->serialize())->update([ 'ladder_points' => 0 ]);
    }

    /**
     * In the case where this projector has received an event that contains no difference, then the event was in error,
     * and we do not wish to record it.
     *
     * @param PointsChangedEvent $event
     * @return bool
     */
    protected function thereIsADifference(PointsChangedEvent $event)
    {
        return ($event->difference() !== 0);
    }
}
