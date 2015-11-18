<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

use Depotwarehouse\Blumba\Domain\ValueObject;
use Depotwarehouse\Blumba\Domain\ValueObjectInterface;

class HeroPoints extends ValueObject
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

    public function any()
    {
        return $this->getPoints() !== 0;
    }

    public function getPoints()
    {
        return (int)$this->points;
    }

    public function invert()
    {
        return new static($this->getPoints() * -1);
    }

    public function toString()
    {
        return (string)$this->points;
    }

    /**
     * Compare this ValueObject to another of the same type.
     *
     * @param ValueObjectInterface $otherObject
     * @return bool
     */
    protected function equalsSelf(ValueObjectInterface $otherObject)
    {
        /** @var self $otherObject */
        return $this->getPoints() === $otherObject->getPoints();
    }
}
