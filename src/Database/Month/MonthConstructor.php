<?php

namespace Depotwarehouse\LadderTracker\Database\Month;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Database\EntityConstructor;
use Depotwarehouse\LadderTracker\ValueObjects\Month\MonthEndDate;
use Depotwarehouse\LadderTracker\ValueObjects\Month\MonthId;

class MonthConstructor extends EntityConstructor
{

    public function createInstance(array $attributes)
    {
        if (!$attributes['end_date'] instanceof MonthEndDate) {
            $attributes['end_date'] = new MonthEndDate(new Carbon($attributes['end_date']));
        }
        $month = new Month(new MonthId($attributes['id']), $attributes['users'], $attributes['end_date']);
        return $month;
    }

    public function create(array $attributes)
    {
        $monthId = new MonthId($this->generateId());
        $end_date = new MonthEndDate();
        $month = new Month($monthId, $attributes['users'], $end_date);
        return $month;
    }
}
