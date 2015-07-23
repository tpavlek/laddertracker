<?php

namespace Depotwarehouse\LadderTracker;

use Depotwarehouse\BattleNetSC2Api\ApiService;
use Depotwarehouse\BattleNetSC2Api\Region;
use Depotwarehouse\LadderTracker\Database\EventRecorder;
use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\Database\User\UserHeroPointProjector;
use Depotwarehouse\LadderTracker\Database\User\UserLadderPointProjector;
use Depotwarehouse\LadderTracker\Database\User\UserRankProjector;
use Depotwarehouse\LadderTracker\Database\User\UserRegistrationProjector;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\Events\Heroes\HeroPointChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\PointChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\RankChangedEvent;
use Depotwarehouse\LadderTracker\Events\User\UserWasRegisteredEvent;
use Illuminate\Database\Capsule\Manager;
use League\Event\Emitter;

class Tracker
{
    protected $api_key;

    protected $capsule;
    protected $emitter;

    protected $eventRecorder;

    public function __construct(Manager $capsule, Emitter $emitter)
    {
        $this->capsule = $capsule;
        $this->emitter = $emitter;
        $this->api_key = getenv('BNET_API_KEY');
        $this->eventRecorder = $this->buildEventRecorder();

        $this->bindUserRegistrationListener();
        $this->bindRankChangeListeners();
        $this->bindHeroPointChangeListener();
    }

    protected function buildEventRecorder()
    {
        $eventRecorder = new EventRecorder($this->capsule->getConnection(), $this->getEventProjectors());
        return $eventRecorder;
    }

    protected function bindUserRegistrationListener()
    {
        $this->emitter->addListener(UserWasRegisteredEvent::class, $this->eventRecorder);
    }

    protected function bindRankChangeListeners()
    {
        $this->emitter->addListener(PointChangedEvent::class, $this->eventRecorder);
        $this->emitter->addListener(RankChangedEvent::class, $this->eventRecorder);
    }

    protected function bindHeroPointChangeListener()
    {
        $this->emitter->addListener(HeroPointChangedEvent::class, $this->eventRecorder);
    }

    public function updateAll()
    {
        $syncService = new BNetApiSyncService(
            new UserRepository($this->capsule->getConnection(), new UserConstructor()),
            new ApiService($this->api_key, Region::America),
            $this->emitter
        );

        $syncService->update();
    }

    private function getEventProjectors()
    {
        return [
            HeroPointChangedEvent::class => [
                UserHeroPointProjector::class,
            ],
            PointChangedEvent::class => [
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
