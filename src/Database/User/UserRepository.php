<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

class UserRepository
{

    const USERS_TABLE_NAME = "laddertracker_users";

    const SORT_LADDER_POINTS = "ladder_points";

    protected $userTable;
    protected $userConstructor;

    public function __construct(ConnectionInterface $database, UserConstructor $constructor)
    {
        $this->userTable = $database->table(self::USERS_TABLE_NAME);
        $this->userConstructor = $constructor;
    }

    public function find($id)
    {
        $userData = $this->userTable->find($id);
        return $this->userConstructor->createInstance((array)$userData);
    }

    public function all()
    {
        $users = new Collection();
        foreach ($this->userTable->select()->get() as $userData) {
            $users->push($this->userConstructor->createInstance((array)$userData));
        }

        return $users;
    }

    public function top($cutoff, $sortBy = self::SORT_LADDER_POINTS)
    {
        $users = new Collection();
        foreach ($this->userTable->orderBy($sortBy, 'DESC')->take($cutoff)->get() as $userData) {
            $users->push($this->userConstructor->createInstance((array)$userData));
        }

        return $users;
    }

}
