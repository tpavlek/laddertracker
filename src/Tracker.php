<?php

namespace Depotwarehouse\LadderTracker;

use Depotwarehouse\BattleNetSC2Api\ApiService;
use Depotwarehouse\BattleNetSC2Api\Region;
use Depotwarehouse\LadderTracker\Database\EventRecorder;
use Depotwarehouse\LadderTracker\Database\Month\MonthEndProjector;
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

        $this->bindUserRegistrationListener();
        $this->bindRankChangeListeners();
        $this->bindHeroPointChangeListener();
        $this->bindEndMonthListener();
    }

    protected function buildEventRecorder()
    {
        $eventRecorder = new EventRecorder($this->connection, $this->getEventProjectors());
        return $eventRecorder;
    }

    protected function bindUserRegistrationListener()
    {
        $this->emitter->addListener(UserWasRegisteredEvent::class, $this->eventRecorder);
    }

    protected function bindRankChangeListeners()
    {
        $this->emitter->addListener(PointsChangedEvent::class, $this->eventRecorder);
        $this->emitter->addListener(RankChangedEvent::class, $this->eventRecorder);
    }

    protected function bindHeroPointChangeListener()
    {
        $this->emitter->addListener(HeroPointsChangedEvent::class, $this->eventRecorder);
    }

    protected function bindEndMonthListener()
    {
        $this->emitter->addListener(MonthWasEndedEvent::class, $this->eventRecorder);
    }
    public function updateAll()
    {
        $syncService = new BNetApiSyncService(
            new UserRepository($this->connection, new UserConstructor()),
            new ApiService($this->api_key, Region::America),
            $this->emitter
        );

        $syncService->update();
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
            ]
        ];
    }

}
