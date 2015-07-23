<?php

require 'bootstrap.php';

\Illuminate\Database\Capsule\Manager::schema()->create('laddertracker_events', function(\Illuminate\Database\Schema\Blueprint $table) {

    $table->increments('id');
    $table->string('eventName');
    $table->string('aggregateId');
    $table->text('eventPayload');

    $table->timestamp('timestamp');
});

\Illuminate\Database\Capsule\Manager::schema()->create('laddertracker_users', function (\Illuminate\Database\Schema\Blueprint $table) {

    $table->string('id')->unique();
    $table->string('display_name');
    $table->integer('bnet_id')->unsigned()->unique();
    $table->string('bnet_url')->unique();

    $table->integer('ladder_rank')->unsigned();
    $table->integer('ladder_points')->unsigned();
});
