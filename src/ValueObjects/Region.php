<?php

namespace Depotwarehouse\LadderTracker\ValueObjects;

use Depotwarehouse\Blumba\Domain\ValueObject;
use Depotwarehouse\Blumba\Domain\ValueObjectInterface;

class Region extends ValueObject
{

    private $region;

    public function __construct($region)
    {
        if ($region != \Depotwarehouse\BattleNetSC2Api\Region::America && $region != \Depotwarehouse\BattleNetSC2Api\Region::Europe)
        {
            throw new \InvalidArgumentException("Invalid region $region");
        }

        $this->region = $region;
    }

    /**
     * Compare this ValueObject to another of the same type.
     *
     * @param ValueObjectInterface $otherObject
     * @return bool
     */
    protected function equalsSelf(ValueObjectInterface $otherObject)
    {
        return $this->toString() == $otherObject->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (string)$this->region;
    }
}
