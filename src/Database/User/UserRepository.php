<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Carbon\Carbon;
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
            array_merge((array)$userData, [ 'last_played_game' => $this->lastPlayedGame($userData->id) ])
        );
    }

    public function all()
    {
        $users = new Collection();
        foreach ($this->userTable()->select()->get() as $userData) {
            $users->push($this->userConstructor->createInstance(
                array_merge((array)$userData, [ 'last_played_game' => $this->lastPlayedGame($userData->id) ])
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
                    array_merge((array)$userData, [ 'last_played_game' => $this->lastPlayedGame($userData->id) ])
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

    public function top($cutoff, Region $region, $sortBy = self::SORT_LADDER_RANK, $sortByType = 'ASC', $secondSort = self::SORT_HERO_POINTS_UPDATE)
    {
        return collect($this->userTable()
            ->where('region', '=', $region->toString())
            ->orderBy($sortBy, $sortByType)
            ->orderBy($secondSort, 'ASC')
            ->take($cutoff)
            ->get()
        )->map(function ($userData) {
            return $this->userConstructor->createInstance(
                array_merge((array)$userData, [ 'last_played_game' => $this->lastPlayedGame($userData->id) ] )
            );
        });
    }

    private function userTable()
    {
        return $this->connection->table(self::USERS_TABLE_NAME);
    }

    private function lastPlayedGame($userId)
    {
        $result = $this->connection->table('laddertracker_events')
            ->where('aggregateId', '=', $userId)
            ->where('eventName', '=', RankChangedEvent::class)
            ->select([ \DB::raw('max(timestamp) as timestamp') ])
            ->first();

        return new Carbon($result->timestamp);
    }


}
