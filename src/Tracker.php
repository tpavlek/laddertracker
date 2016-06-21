<?php

namespace Depotwarehouse\LadderTracker;

use Depotwarehouse\BattleNetSC2Api\ApiService;
use Depotwarehouse\BattleNetSC2Api\Region;
use Depotwarehouse\LadderTracker\Database\EventRecorder;
use Depotwarehouse\LadderTracker\Database\Month\MonthEndProjector;
use Depotwarehouse\LadderTracker\Database\User\UserClanProjector;
use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\Database\User\UserHeroPointProjector;
use Depotwarehouse\LadderTracker\Database\User\UserLadderPointProjector;
use Depotwarehouse\LadderTracker\Database\User\UserRankProjector;
use Depotwarehouse\LadderTracker\Database\User\UserRegistrationProjector;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\Events\Heroes\MonthWasEndedEvent;
use Depotwarehouse\LadderTracker\Events\Heroes\HeroPointsChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\PointsChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\RankChangedEvent;
use Depotwarehouse\LadderTracker\Events\User\ClanTagChangedEvent;
use Depotwarehouse\LadderTracker\Events\User\UserWasRegisteredEvent;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\ConnectionInterface;
use League\Event\Emitter;

class Tracker
{
    protected $api_key;

    protected $connection;
    protected $emitter;

    protected $eventRecorder;

    public function __construct(ConnectionInterface $connection, Emitter $emitter)
    {
        $this->connection = $connection;
        $this->emitter = $emitter;
        $this->api_key = getenv('BNET_API_KEY');
        $this->eventRecorder = $this->buildEventRecorder();

        $this->bindEventListeners();
    }

    protected function bindEventListeners()
    {
        collect($this->getEventProjectors())
            ->keys()
            ->each(function ($eventClass) {
                $this->emitter->addListener($eventClass, $this->eventRecorder);
            });
    }

    protected function buildEventRecorder()
    {
        $eventRecorder = new EventRecorder($this->connection, $this->getEventProjectors());
        return $eventRecorder;
    }

    /**
     * Query the grandmaster ladder, and sync all results for both Europe and America
     */
    public function updateAll()
    {
        (new BNetApiSyncService(
            new UserRepository($this->connection, new UserConstructor()),
            new ApiService($this->api_key, Region::America),
            $this->emitter
        ))->update(\Depotwarehouse\LadderTracker\ValueObjects\Region::america());

        (new BNetApiSyncService(
            new UserRepository($this->connection, new UserConstructor()),
            new ApiService($this->api_key, Region::Europe),
            $this->emitter
        ))->update(\Depotwarehouse\LadderTracker\ValueObjects\Region::europe());
    }

    private function getEventProjectors()
    {
        return [
            MonthWasEndedEvent::class => [
                MonthEndProjector::class
            ],
            HeroPointsChangedEvent::class => [
                UserHeroPointProjector::class,
            ],
            PointsChangedEvent::class => [
                UserLadderPointProjector::class,
            ],
            RankChangedEvent::class => [
                UserRankProjector::class
            ],
            UserWasRegisteredEvent::class => [
                UserRegistrationProjector::class
            ],
            ClanTagChangedEvent::class => [
                UserClanProjector::class
            ]
        ];
    }

}
