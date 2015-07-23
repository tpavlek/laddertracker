<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

use Depotwarehouse\LadderTracker\ValueObjects\Contracts\ValueObject;

class DisplayName implements ValueObject
{

    protected $display_name;

    public function __construct($display_name)
    {
        $this->display_name = $display_name;
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
        return (string)$this->display_name;
    }
}
