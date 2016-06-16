<?php

namespace Depotwarehouse\LadderTracker\Database\Month;

use Carbon\Carbon;
use Depotwarehouse\Blumba\Domain\EntityConstructor;
use Depotwarehouse\LadderTracker\ValueObjects\Month\MonthEndDate;
use Depotwarehouse\LadderTracker\ValueObjects\Month\MonthId;
use Depotwarehouse\LadderTracker\ValueObjects\Region;

class MonthConstructor extends EntityConstructor
{

    public function createInstance(array $attributes)
    {
        if (!$attributes['end_date'] instanceof MonthEndDate) {
            $attributes['end_date'] = new MonthEndDate(new Carbon($attributes['end_date']));
        }

        $month = new Month(new MonthId($attributes['id']), $attributes['users'], $attributes['end_date'], $attributes['region']);
        return $month;
    }

    public function create(array $attributes)
    {
        $monthId = new MonthId($this->generateId());
        $end_date = new MonthEndDate();

        $region = ($attributes['region'] instanceof Region) ? $attributes['region'] : new Region($attributes['region']);

        $month = new Month($monthId, $attributes['users'], $end_date, $region);
        return $month;
    }
}
