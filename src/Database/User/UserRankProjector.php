<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\Blumba\ReadModel\Projector;
use Depotwarehouse\LadderTracker\Events\Ladder\RankChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\UserDroppedOutOfGrandmasterEvent;
use Illuminate\Database\ConnectionInterface;

class UserRankProjector extends Projector
{

    protected $userTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->userTable = $connection->table(UserRepository::USERS_TABLE_NAME);
    }

    public function projectRankChanged(RankChangedEvent $event)
    {
        $this->userTable
            ->where('id', '=', $event->getPayload()['userId'])
            ->decrement('ladder_rank', $event->difference());
    }

    public function projectUserDroppedOutOfGrandmaster(UserDroppedOutOfGrandmasterEvent $event)
    {
        $this->userTable
            ->where('id', '=', $event->getUser()->getId()->serialize())
            ->update([ 'ladder_rank' => 201 ]);
    }
}
