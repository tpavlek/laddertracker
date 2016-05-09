<?php

namespace Depotwarehouse\LadderTracker\Tests\Commands;


use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\Client\Web\Tests\TestCase;
use Depotwarehouse\LadderTracker\Commands\RegisterUserCommand;
use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use League\Event\Emitter;

class RegisterUserCommandTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_can_register_a_user()
    {
        $c = new RegisterUserCommand($this->app->make(Emitter::class), new UserConstructor());
        
        $c->register(
            new DisplayName("New User"),
            new BnetId(12345),
            new BnetUrl("http://mock-bnet-url.com"),
            new Region(\Depotwarehouse\BattleNetSC2Api\Region::America)
        );

        $this->seeInDatabase("laddertracker_users", [ 'display_name' => "New User", 'bnet_id' => 12345, 'region' => \Depotwarehouse\BattleNetSC2Api\Region::America ]);
    }

}
