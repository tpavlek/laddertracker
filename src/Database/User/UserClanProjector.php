<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\Blumba\ReadModel\Projector;
use Depotwarehouse\LadderTracker\Events\User\ClanTagChangedEvent;
use Illuminate\Database\ConnectionInterface;

class UserClanProjector extends Projector
{

    protected $userTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->userTable = $connection->table(UserRepository::USERS_TABLE_NAME);
    }

    public function projectClanTagChanged(ClanTagChangedEvent $event)
    {
        $this->userTable->where('id', '=', $event->getAggregateId())
            ->update([ 'clan_tag' => $event->getPayload()['clan_tag']]);
    }

}
