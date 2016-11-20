<?php

namespace Depotwarehouse\LadderTracker\Database\Month;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\ValueObjects\Month\MonthEndDate;
use Depotwarehouse\LadderTracker\ValueObjects\Month\MonthId;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Collection;

class MonthRepository
{

    const MONTH_TABLE_NAME = "hero_points_month";
    const LOCK_TABLE_NAME = "lock_dates";

    protected $monthTable;
    protected $monthConstructor;
    protected $lockTable;
    protected $userConstructor;

    public function __construct(ConnectionInterface $connection, MonthConstructor $monthConstructor, UserConstructor $userConstructor)
    {
        $this->monthTable = $connection->table(self::MONTH_TABLE_NAME);
        $this->lockTable = $connection->table(self::LOCK_TABLE_NAME);
        $this->monthConstructor = $monthConstructor;
        $this->userConstructor = $userConstructor;
    }

    public function all()
    {
        return collect($this->monthTable->orderBy('end_date', 'DESC')->get())
            ->groupBy('month_id')
            ->filter(function (Collection $monthData) { return $monthData->count(); })
            ->map(function (Collection $monthData) {
                // $monthData takes the form of several user records associated with a month.
                // The MonthID, EndDate and Region will be the same for all these records, so we take the first one.
                $month_id = new MonthId($monthData->first()->month_id);
                $month_end_date = new MonthEndDate(new Carbon($monthData->first()->end_date));
                $region = new Region($monthData->first()->region);

                $users = collect($monthData)
                    ->map(function ($userData) {

                        return $this->userConstructor->createInstance(
                            array_only(
                                (array)$userData,
                                [ 'user_id', 'display_name', 'hero_points', 'bnet_id', 'bnet_url' ]
                            )
                        );

                    })
                    ->sortByDesc(function(User $user) { return $user->getHeroPoints()->getPoints(); } )
                    ->values();

                return $this->monthConstructor->createInstance([ 'id' => $month_id, 'end_date' => $month_end_date, 'users' => $users, 'region' => $region ]);

            })
            ->sortByDesc(function (Month $month) {
                return $month->getEndDate()->serialize();
            })
            ->values();
    }

    public function getNextLockDate(Region $region)
    {
        // get the next lock date that's after the current time for a region
        $currentTime = Carbon::now();
        $dbLockTime = $this->lockTable->where([['lock_time', '>', $currentTime], ['region', '=', $region->serialize()]])->orderBy('lock_time', 'ASC')->first();
        $lockTime = $currentTime;
        if($dbLockTime) {
            $lockTime = new Carbon($dbLockTime->lock_time);
        }
        
        return $lockTime->diffInSeconds($currentTime);

        $diff = $lockTime->diff($currentTime);
        return $diff->format('%d days %h hours %i minutes %s seconds');
    }

}
