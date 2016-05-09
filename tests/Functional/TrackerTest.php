<?php

namespace Depotwarehouse\LadderTracker\Tests\Functional;


use Depotwarehouse\LadderTracker\Client\Web\Tests\TestCase;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Events\Ladder\PointsChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\RankChangedEvent;
use Depotwarehouse\LadderTracker\Events\User\UserWasRegisteredEvent;
use Depotwarehouse\LadderTracker\Tracker;
use DB;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use Depotwarehouse\LadderTracker\ValueObjects\User\UserId;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use League\Event\Emitter;
use Rhumsaa\Uuid\Uuid;

class TrackerTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_handles_europe_player_rank_change()
    {
        $emitter = $this->app->make(Emitter::class);

        $id = new UserId(Uuid::uuid4()->toString());

        $user = new User(
            $id,
            new DisplayName("mock_user"),
            new BnetId(12345),
            new BnetUrl("http://mock-bnet-url.com"),
            Rank::userIsNotInGrandmaster(),
            HeroPoints::none(),
            new Region(\Depotwarehouse\BattleNetSC2Api\Region::Europe)
        );

        $emitter->emit(new UserWasRegisteredEvent($user));

        $emitter->emit(new RankChangedEvent($user, Rank::userIsRankedWithPoints(150, 400))); // TODO these events are tightly coupled, maybe just merge them?
        $emitter->emit(new PointsChangedEvent($user, Rank::userIsRankedWithPoints(150, 400)));

        $this->seeInDatabase('laddertracker_users', [ 'id' => $id->toString(), 'ladder_rank' => 150, 'ladder_points' => 400 ]);
    }
}
