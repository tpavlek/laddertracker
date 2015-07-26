<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\Month;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\ValueObjects\Contracts\ValueObject;

class MonthEndDate implements ValueObject
{

    protected $date;

    public function __construct(Carbon $date = null)
    {
        if (is_null($date)) {
            $this->date = Carbon::now();
        } else {
            $this->date = $date;
        }
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function getDate()
    {
        return $this->date;
    }

    public function equals(ValueObject $otherObject)
    {
        if ($otherObject instanceof MonthEndDate) {
            return $this->getDate()->eq($otherObject->getDate());
        }

        return $this->toString() === $otherObject->toString();

    }
    public function toString()
    {
        return $this->getDate()->toDateTimeString();
    }
}
