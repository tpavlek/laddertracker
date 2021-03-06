<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Events\Ladder\PointsChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\RankChangedEvent;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

class UserRepository
{

    const USERS_TABLE_NAME = "laddertracker_users";

    const SORT_LADDER_POINTS = "ladder_points";
    const SORT_LADDER_RANK = "ladder_rank";
    const SORT_HERO_POINTS = "hero_points";
    const SORT_HERO_POINTS_UPDATE = "hero_points_updated_at";

    protected $userTable;
    private $connection;
    protected $userConstructor;

    public function __construct(ConnectionInterface $database, UserConstructor $constructor)
    {
        $this->connection = $database;
        $this->userConstructor = $constructor;
    }

    public function find($id)
    {
        $userData = $this->userTable()->find($id);
        return $this->userConstructor->createInstance(
            array_merge((array)$userData, [ 'last_played_game' => $this->lastPlayedGame($userData) ])
        );
    }

    public function all()
    {
        $users = new Collection();
        foreach ($this->userTable()->select()->orderBy('display_name', 'ASC')->get() as $userData) {
            $users->push($this->userConstructor->createInstance(
                array_merge((array)$userData, [ 'last_played_game' => $this->lastPlayedGame($userData) ])
            ));
        }

        return $users;
    }

    public function region(Region $region)
    {
        return collect($this->userTable()
            ->where('region', '=', $region->serialize())
            ->get()
        )
            ->map(function ($userData) {
                return $this->userConstructor->createInstance(
                    array_merge((array)$userData, [ 'last_played_game' => $this->lastPlayedGame($userData) ])
                );
            });
    }

    public function rankingChanges($cutoff, Region $region)
    {
        return $this->userTable()
            ->where('region', '=', $region->toString())
            ->orderBy(self::SORT_LADDER_RANK, 'ASC')
            ->orderBy(self::SORT_HERO_POINTS_UPDATE, 'ASC')
            ->join('laddertracker_events', 'laddertracker_events.aggregateId', '=', "laddertracker_users.id")
            ->where('laddertracker_events.eventName', '=', RankChangedEvent::class)
            ->select([ 'laddertracker_users.*', 'laddertracker_events.eventPayload as change' ])
            ->take($cutoff)
            ->get();

        /*->map(function ($userData) {
            return $this->userConstructor->createInstance((array)$userData);
        });*/
    }

    public function top($cutoff, Region $region, $sortBy = self::SORT_LADDER_POINTS, $sortByType = 'ASC', $secondSort = self::SORT_HERO_POINTS_UPDATE)
    {
        return collect($this->userTable()
            ->where('region', '=', $region->toString())
            ->orderBy($sortBy, $sortByType)
            ->orderBy($secondSort, 'ASC')
            ->take($cutoff)
            ->get()
        )->map(function ($userData) {
            return $this->userConstructor->createInstance(
                array_merge((array)$userData, [ 'last_played_game' => $this->lastPlayedGame($userData) ] )
            );
        });
    }

    private function userTable()
    {
        return $this->connection->table(self::USERS_TABLE_NAME);
    }

    private function lastPlayedGame($userData)
    {
        if(! $userData->last_game || $userData->last_game < Carbon::createFromDate(2015)) {
            return Carbon::createFromDate(null, 10, 26);
        }
        return new Carbon($userData->last_game);
    }


}
