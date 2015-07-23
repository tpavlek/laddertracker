<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

use Depotwarehouse\LadderTracker\ValueObjects\Contracts\ValueObject;

class HeroPoints implements ValueObject
{

    protected $points;

    public function __construct($points = 0)
    {
        $this->points = $points;
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function getPoints()
    {
        return (int)$this->points;
    }

    public function getInverse()
    {
        return new static($this->getPoints() * -1);
    }

    public function toString()
    {
        return (string)$this->points;
    }

    public function equals(ValueObject $otherObject)
    {
        if ($otherObject instanceof HeroPoints) {
            return $this->getPoints() === $otherObject->getPoints();
        }

        return $this->toString() === $otherObject->toString();

    }
}
