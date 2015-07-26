<?php

namespace Depotwarehouse\LadderTracker\Database\Month;

use Depotwarehouse\LadderTracker\Database\Entity;
use Depotwarehouse\LadderTracker\ValueObjects\Month\MonthEndDate;
use Depotwarehouse\LadderTracker\ValueObjects\Month\MonthId;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Month extends Entity implements Arrayable
{

    protected $id;
    protected $users;
    protected $end_date;

    public function __construct(MonthId $monthId, Collection $users, MonthEndDate $endDate)
    {
        $this->id = $monthId;
        $this->users = $users;
        $this->end_date = $endDate;
    }

    /**
     * @return MonthId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId()->toString(),
            'end_date' => $this->getEndDate()->toString(),
            'users' => $this->getUsers()->toArray()
        ];
    }
}
