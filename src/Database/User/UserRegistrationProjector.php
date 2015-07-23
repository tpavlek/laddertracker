<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\LadderTracker\Database\Contracts\Projector;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Depotwarehouse\LadderTracker\Events\User\UserWasRegisteredEvent;
use Illuminate\Database\ConnectionInterface;

class UserRegistrationProjector implements Projector
{

    protected $userTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->userTable = $connection->table(UserRepository::USERS_TABLE_NAME);
    }

    public function project(SerializableEvent $event)
    {
        /** @var UserWasRegisteredEvent $event */

        $user = $event->getUser();
        $this->userTable->insert([
            $user->toArray()
        ]);
    }
}
