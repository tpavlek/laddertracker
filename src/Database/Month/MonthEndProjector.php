<?php

namespace Depotwarehouse\LadderTracker\Database\Month;

use Depotwarehouse\Blumba\ReadModel\Projector;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Events\Heroes\MonthWasEndedEvent;
use Illuminate\Database\ConnectionInterface;

class MonthEndProjector extends Projector
{

    protected $monthTable;

    public function __construct(ConnectionInterface $connection)
    {
        $this->monthTable = $connection->table('hero_points_month');
    }

    public function projectMonthWasEnded(MonthWasEndedEvent $event)
    {
        $month = $event->getMonth();

        foreach ($month->getUsers() as $user) {
            /** @var User $user */

            $data = $user->toArray();
            $data['user_id'] = $data['id'];
            $data['month_id'] = $month->getId()->toString();
            $data['end_date'] = $month->getEndDate()->toString();
            unset($data['paypal']);
            unset($data['id']);
            unset($data['ladder_rank']);
            unset($data['ladder_points']);

            $this->monthTable->insert($data);
        }
    }
}
