<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\LadderTracker\Database\Contracts\Projector;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Illuminate\Database\ConnectionInterface;

class UserRankProjector implements Projector
{

    protected $userTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->userTable = $connection->table(UserRepository::USERS_TABLE_NAME);
    }

    public function project(SerializableEvent $event)
    {
        $this->userTable->where('id', '=', $event->getPayload()['userId'])->decrement('ladder_rank', $event->getPayload()['difference']);
    }


}
