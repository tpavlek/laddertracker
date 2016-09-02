<?php

namespace Depotwarehouse\LadderTracker\Tests\IntegrationTests\Database\User;


use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Events\Ladder\UserDroppedOutOfGrandmasterEvent;
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
use League\Event\Emitter;

class UserLadderPointProjectorTest extends ScenarioTest
{

    /**
     * @test
     */
    public function it_clears_ladder_points_when_a_user_drops_out_of_grandmaster()
    {
        $fallingOutOfGM = new User(new UserId(9001), new ClanTag("SC2CTL"), new DisplayName("Falling_User"), new BnetId(9001), new BnetUrl('http://battle.net/falling_user'), Rank::userIsRankedWithPoints(200, 1), HeroPoints::none(), Region::america());

        $this->scenario(
            new UserWasRegisteredEvent($fallingOutOfGM)
        );

        $this->app->make(Emitter::class)->emit(new UserDroppedOutOfGrandmasterEvent($fallingOutOfGM));

        $this->seeInDatabase('laddertracker_users', [ 'id' => 9001, 'ladder_rank' => 201, 'ladder_points' => 0 ]);
    }
}
