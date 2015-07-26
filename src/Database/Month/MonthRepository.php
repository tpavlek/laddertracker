<?php

namespace Depotwarehouse\LadderTracker\Database\Month;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\ValueObjects\Month\MonthEndDate;
use Depotwarehouse\LadderTracker\ValueObjects\Month\MonthId;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Collection;

class MonthRepository
{

    const MONTH_TABLE_NAME = "hero_points_month";

    protected $monthTable;
    protected $monthConstructor;
    protected $userConstructor;

    public function __construct(ConnectionInterface $connection, MonthConstructor $monthConstructor, UserConstructor $userConstructor)
    {
        $this->monthTable = $connection->table(self::MONTH_TABLE_NAME);
        $this->monthConstructor = $monthConstructor;
        $this->userConstructor = $userConstructor;
    }

    public function all()
    {
        $months = new Collection();
        $monthGroups = (new Collection($this->monthTable->orderBy('end_date', 'DESC')->get()))->groupBy('month_id');
        foreach ($monthGroups as $monthData) {

            /** @var Collection $monthData */
            if ($monthData->count()) {
                $month_id = new MonthId($monthData->first()->month_id);
                $month_end_date = new MonthEndDate(new Carbon($monthData->first()->end_date));

                $users = new Collection();

                foreach ($monthData as $userData) {
                    $user = $this->userConstructor->createInstance(
                        array_only(
                            (array)$userData,
                            [ 'user_id', 'display_name', 'hero_points', 'bnet_id', 'bnet_url' ]
                        ));
                    $users->push($user);
                }

                $users = $users->sortByDesc(function(User $user) { return $user->getHeroPoints()->getPoints(); } );

                $months->push($this->monthConstructor->createInstance([ 'id' => $month_id, 'end_date' => $month_end_date, 'users' => $users]));
            }
        }

        return $months;
    }

}
