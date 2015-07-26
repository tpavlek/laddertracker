<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\Month;

use Depotwarehouse\LadderTracker\ValueObjects\Contracts\ValueObject;

class MonthId implements ValueObject
{

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
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
