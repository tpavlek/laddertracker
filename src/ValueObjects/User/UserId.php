<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

class UserId
{

    protected $id;

    public function __construct($userId)
    {
        $this->id = $userId;
    }

    public function __toString()
    {
        return $this->id;
    }

}
