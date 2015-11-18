<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;


use Depotwarehouse\Blumba\Domain\ValueObject;
use Depotwarehouse\Blumba\Domain\ValueObjectInterface;

class DisplayName extends ValueObject
{

    protected $display_name;

    public function __construct($display_name)
    {
        $this->display_name = $display_name;
    }

    public function toString()
    {
        return (string)$this->display_name;
    }

    /**
     * Compare this ValueObject to another of the same type.
     *
     * @param ValueObjectInterface $otherObject
     * @return bool
     */
    protected function equalsSelf(ValueObjectInterface $otherObject)
    {
        return $this->equalsOther($otherObject);
    }
}
