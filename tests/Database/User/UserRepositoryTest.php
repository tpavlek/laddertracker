<?php

namespace Depotwarehouse\LadderTracker\Tests\IntegrationTests\Database\User;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Client\Web\Tests\TestCase;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\Events\Ladder\PointsChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\RankChangedEvent;
use Depotwarehouse\LadderTracker\Events\User\UserWasRegisteredEvent;
use Depotwarehouse\LadderTracker\Tests\ScenarioTest;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\ClanTag;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use Depotwarehouse\LadderTracker\ValueObjects\User\UserId;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use League\Event\Emitter;

class UserRepositoryTest extends ScenarioTest
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_retrieves_the_last_played_game_date()
    {
        Carbon::setTestNow(new Carbon("2016-07-02"));

        $user = new User(new UserId(9001),
            new ClanTag("SC2CTL"),
            new DisplayName("mock_user"),
            new BnetId(9001),
            new BnetUrl('http://battle.net/some_user'),
            Rank::userIsRankedWithPoints(2, 799),
            HeroPoints::none(),
            Region::europe()
        );

        Carbon::setTestNow(new Carbon('2016-07-25'));

        $this->scenario(
            new UserWasRegisteredEvent($user),
            new PointsChangedEvent($user, Rank::userIsRankedWithPoints(3, 759))
        );

        Carbon::setTestNow(new Carbon('2016-08-13'));

        /** @var UserRepository $repository */
        $repository = $this->app->make(UserRepository::class);
        $dbUser = $repository->find(9001);

        $this->assertTrue($dbUser->lastPlayed()->eq(new Carbon('2016-07-25')));
    }
}
