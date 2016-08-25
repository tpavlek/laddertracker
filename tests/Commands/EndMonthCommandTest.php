<?php

namespace Depotwarehouse\LadderTracker\Tests\Commands;


use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Client\Web\Tests\TestCase;
use Depotwarehouse\LadderTracker\Commands\EndMonthCommand;
use Depotwarehouse\LadderTracker\Database\Month\MonthConstructor;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Events\Heroes\HeroPointsChangedEvent;
use Depotwarehouse\LadderTracker\Events\User\UserWasRegisteredEvent;
use Depotwarehouse\LadderTracker\HeroPointIssuerService;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\ClanTag;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use Depotwarehouse\LadderTracker\ValueObjects\User\UserId;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use League\Event\Emitter;

class EndMonthCommandTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_can_end_a_month()
    {
        $now = Carbon::now();
        Carbon::setTestNow($now);

        $emitter = $this->app->make(Emitter::class);

        $user = new User(new UserId(9001), new ClanTag("FGT"), new DisplayName("Mock_User"), new BnetId(9002), new BnetUrl('http://battle.net/some_user'), new Rank(4, 600), HeroPoints::none(), Region::europe());

        $emitter->emit(new UserWasRegisteredEvent($user));
        $emitter->emit(
            new HeroPointsChangedEvent($user, new HeroPoints(12))
        );

        $command = new EndMonthCommand($this->app->make(HeroPointIssuerService::class), new MonthConstructor());

        $command->run(Region::europe());

        $this->seeInDatabase('hero_points_month', [
            'end_date' => $now->toDateTimeString(),
            'region' => Region::europe()->serialize(),
            'user_id' => "9001",
            'bnet_id' => 9002,
            'hero_points' => 12
        ]);
    }

}
