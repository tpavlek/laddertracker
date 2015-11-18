<?php

namespace Depotwarehouse\LadderTracker\Tests;


use Depotwarehouse\BattleNetSC2Api\ApiService;
use Depotwarehouse\BattleNetSC2Api\Entity\Grandmaster\Player;
use Depotwarehouse\LadderTracker\BNetApiSyncService;
use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\Events\Ladder\PointChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\RankChangedEvent;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Illuminate\Support\Collection;
use League\Event\Emitter;
use Mockery as m;

class BNetApiSyncServiceTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function test_it_emits_rank_and_point_change_events_if_local_user_not_in_grandmaster()
    {
        // TODO write some tests
        $this->assertTrue(true);
    }

}
