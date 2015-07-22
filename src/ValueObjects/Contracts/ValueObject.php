<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\Contracts;

interface ValueObject
{

    public function equals(ValueObject $otherObject);

}
