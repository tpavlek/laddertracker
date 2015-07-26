<?php

namespace Depotwarehouse\LadderTracker\Database\Month;

use Depotwarehouse\LadderTracker\Database\Contracts\Projector;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Events\Heroes\EndMonthEvent;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionInterface;
use phpDocumentor\Reflection\DocBlock\Type\Collection;

class MonthEndProjector implements Projector
{

    protected $monthTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->monthTable = $connection->table('hero_points_month');

    }

    public function project(SerializableEvent $event)
    {
        if (!$event instanceof EndMonthEvent) {
            throw new \InvalidArgumentException("MonthEndProjector does not know how to project event of type: {$event->getName()}");
        }

        $month = $event->getMonth();

        foreach ($month->getUsers() as $user) {
            /** @var User $user */

            $data = $user->toArray();
            $data['user_id'] = $data['id'];
            $data['month_id'] = $month->getId()->toString();
            $data['end_date'] = $month->getEndDate()->toString();
            unset($data['id']);
            unset($data['ladder_rank']);
            unset($data['ladder_points']);


            $this->monthTable->insert($data);
        }
    }
}
