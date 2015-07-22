<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

class UserRepository
{

    const USERS_TABLE_NAME = "laddertracker_users";

    protected $userTable;
    protected $userConstructor;

    public function __construct(ConnectionInterface $database, UserConstructor $constructor)
    {
        $this->userTable = $database->table(self::USERS_TABLE_NAME);
        $this->userConstructor = $constructor;
    }

    public function all()
    {
        $users = new Collection();
        foreach ($this->userTable->select()->get() as $userData) {
            $users->push($this->userConstructor->createInstance((array)$userData));
        }

        return $users;
    }

}
