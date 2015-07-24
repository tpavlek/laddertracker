<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laddertracker_events', function(Blueprint $table) {
            $table->increments('id');
            $table->string('eventName');
            $table->string('aggregateId');
            $table->text('eventPayload');

            $table->timestamp('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('laddertracker_events');
    }
}
