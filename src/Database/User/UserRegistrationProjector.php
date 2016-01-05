<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\Blumba\ReadModel\Projector;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Depotwarehouse\LadderTracker\Events\User\UserWasRegisteredEvent;
use Illuminate\Database\ConnectionInterface;

class UserRegistrationProjector extends Projector
{

    protected $userTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->userTable = $connection->table(UserRepository::USERS_TABLE_NAME);
    }

    public function projectUserWasRegistered(UserWasRegisteredEvent $event)
    {
        $user = $event->getUser();
        $this->userTable->insert([
            $user->toArray()
        ]);
    }
}
