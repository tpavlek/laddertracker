<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\Month;

use Carbon\Carbon;
use Depotwarehouse\Blumba\Domain\ValueObject;
use Depotwarehouse\Blumba\Domain\ValueObjectInterface;

class MonthEndDate extends ValueObject
{

    protected $date;

    public function __construct(Carbon $date = null)
    {
        $this->date = (is_null($date)) ? Carbon::now() : $date;
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function getDate()
    {
        return $this->date;
    }

    public function toString()
    {
        return $this->getDate()->toDateTimeString();
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
        return $this->getDate()->eq($otherObject->getDate());
    }
}
