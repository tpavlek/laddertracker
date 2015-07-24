<?php

use Illuminate\Database\Capsule\Manager;

require 'vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__);

date_default_timezone_set(getenv('DEFAULT_TIMEZONE'));

$capsule = new Manager();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => getenv('DATABASE_NAME'),
    'username' => getenv('DATABASE_USERNAME'),
    'password' => getenv('DATABASE_PASSWORD'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();

$emitter = new \League\Event\Emitter();

$tracker = new \Depotwarehouse\LadderTracker\Tracker($capsule, $emitter);
