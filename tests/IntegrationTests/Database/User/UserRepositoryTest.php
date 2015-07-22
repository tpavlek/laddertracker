<?php

namespace Depotwarehouse\LadderTracker\Tests\IntegrationTests\Database\User;

use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Illuminate\Database\Capsule\Manager;

class UserRepositoryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_it_retrieves_all_records()
    {
        $capsule = new Manager();
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'ladderheroes',
            'username' => 'root',
            'password' => 'green',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $userRepository = new UserRepository($capsule->getConnection('default'), new UserConstructor());

        $users = $userRepository->all();

        $this->assertEquals(2, $users->count());
        $this->assertEquals(4, $users->first()->getRank()->getLadderRank());
    }

}
