<?php

require 'bootstrap.php';

$app = new \Symfony\Component\Console\Application();

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


$app->run();
