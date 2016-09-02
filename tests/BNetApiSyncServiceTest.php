<?php

namespace Depotwarehouse\LadderTracker\Tests;


use Depotwarehouse\BattleNetSC2Api\ApiService;
use Depotwarehouse\BattleNetSC2Api\Entity\Grandmaster\Player;
use Depotwarehouse\LadderTracker\BNetApiSyncService;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\Events\Ladder\PointsChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\RankChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\UserDroppedOutOfGrandmasterEvent;
use Depotwarehouse\LadderTracker\Events\User\UserWasRegisteredEvent;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\ClanTag;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use Depotwarehouse\LadderTracker\ValueObjects\User\UserId;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use League\Event\Emitter;
use Mockery as m;

class BNetApiSyncServiceTest extends ScenarioTest
{

    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_drops_users_out_of_grandmaster()
    {
        $apiService = m::mock(ApiService::class);

        $service = new BNetApiSyncService($this->app->make(UserRepository::class), $apiService, $this->app->make(Emitter::class));

        $refl = (new \ReflectionClass(Player::class));

        $inGmPlayer = $refl->newInstanceWithoutConstructor();

        $clan = $refl->getProperty('clanTag');
        $clan->setAccessible(true);
        $clan->setValue($inGmPlayer, 'SC2CTL');

        $rank = $refl->getProperty('currentRank');
        $rank->setAccessible(true);
        $rank->setValue($inGmPlayer, 1);

        $points = $refl->getProperty('points');
        $points->setAccessible(true);
        $points->setValue($inGmPlayer, 900);

        $id = $refl->getProperty('id');
        $id->setAccessible(true);
        $id->setValue($inGmPlayer, 9000);



        $players = [
            $inGmPlayer
        ];

        $apiService->shouldReceive('getGrandmasterInformation')->andReturn($players);

        $inGm = new User(new UserId(9000), new ClanTag("SC2CTL"), new DisplayName("GM_User"), new BnetId(9000), new BnetUrl('http://battle.net/gm_user'), Rank::userIsRankedWithPoints(1, 900), HeroPoints::none(), Region::america());
        $fallingOutOfGM = new User(new UserId(9001), new ClanTag("SC2CTL"), new DisplayName("Falling_User"), new BnetId(9001), new BnetUrl('http://battle.net/falling_user'), Rank::userIsRankedWithPoints(200, 1), HeroPoints::none(), Region::america());

        $this->scenario(
            new UserWasRegisteredEvent($inGm),
            new UserWasRegisteredEvent($fallingOutOfGM)
        );

        $service->update(Region::america());

        $this->seeInDatabase('laddertracker_events', [ 'aggregateId' => "9001", 'eventName' => UserDroppedOutOfGrandmasterEvent::class ]);
        $this->notSeeInDatabase('laddertracker_events', [ 'aggregateId' => "9001", 'eventName' => PointsChangedEvent::class ]);
    }

}
