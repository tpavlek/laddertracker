<?php

namespace Depotwarehouse\LadderTracker;

use Depotwarehouse\BattleNetSC2Api\ApiService;
use Depotwarehouse\BattleNetSC2Api\Region;
use Depotwarehouse\LadderTracker\Database\EventRecorder;
use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\Database\User\UserLadderPointProjector;
use Depotwarehouse\LadderTracker\Database\User\UserRankProjector;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\Events\Ladder\PointChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\RankChangedEvent;
use Illuminate\Database\Capsule\Manager;
use League\Event\Emitter;

class Tracker
{
    protected $api_key;

    protected $capsule;

    public function __construct(Manager $capsule)
    {
        $this->capsule = $capsule;
        $this->api_key = getenv('BNET_API_KEY');
    }

    public function updateAll()
    {
        $eventRecorder = new EventRecorder($this->capsule->getConnection("laddertracker"), $this->getEventProjectors());
        $emitter = new Emitter();

        $emitter->addListener(PointChangedEvent::class, $eventRecorder);
        $emitter->addListener(RankChangedEvent::class, $eventRecorder);

        $syncService = new BNetApiSyncService(
            new UserRepository($this->capsule->getConnection("laddertracker"), new UserConstructor()),
            new ApiService($this->api_key, Region::America),
            $emitter
        );

        $syncService->update();
    }

    private function getEventProjectors()
    {
        return [
            PointChangedEvent::class => [
                UserLadderPointProjector::class,
            ],
            RankChangedEvent::class => [
                UserRankProjector::class
            ]
        ];
    }

}
