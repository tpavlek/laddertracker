<?php

use Depotwarehouse\LadderTracker\Database\User\UserConstructor;

require 'startup/bootstrap.php';

$app = new \Symfony\Component\Console\Application();

$heroPointIssuerService = new \Depotwarehouse\LadderTracker\HeroPointIssuerService(
    new \Depotwarehouse\LadderTracker\Database\User\UserRepository($capsule->getConnection(), new UserConstructor()), $emitter
);

$app->add(new \Depotwarehouse\LadderTracker\Client\Console\RegisterUserCommand(
    new \Depotwarehouse\LadderTracker\Commands\RegisterUserCommand($emitter, new \Depotwarehouse\LadderTracker\Database\User\UserConstructor())
));
$app->add(new \Depotwarehouse\LadderTracker\Client\Console\UpdateFromBnetCommand(
    new \Depotwarehouse\LadderTracker\Commands\UpdateFromBnetCommand($tracker)
));
$app->add(new \Depotwarehouse\LadderTracker\Client\Console\AddHeroPointsCommand(
    new \Depotwarehouse\LadderTracker\Commands\AddHeroPointsCommand($emitter),
    new \Depotwarehouse\LadderTracker\Database\User\UserRepository(
        $capsule->getConnection(),
        new \Depotwarehouse\LadderTracker\Database\User\UserConstructor()
    )
));

$app->add(new \Depotwarehouse\LadderTracker\Client\Console\AwardHeroPointsCommand(
    new \Depotwarehouse\LadderTracker\Commands\AwardHeroPointsCommand(
        $heroPointIssuerService
    )
));

$app->add(new \Depotwarehouse\LadderTracker\Client\Console\EndMonthCommand(
    new \Depotwarehouse\LadderTracker\Commands\EndMonthCommand(
        $heroPointIssuerService, new \Depotwarehouse\LadderTracker\Database\Month\MonthConstructor()
    )
));

$app->run();
