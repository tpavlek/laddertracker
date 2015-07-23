<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

use Depotwarehouse\LadderTracker\ValueObjects\Contracts\ValueObject;

class UserId implements ValueObject
{

    protected $id;

    public function __construct($userId)
    {
        $this->id = $userId;
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function equals(ValueObject $otherObject)
    {
        return $this->toString() === $otherObject->toString();
    }

    public function toString()
    {
        return (string)$this->id;
    }
}
