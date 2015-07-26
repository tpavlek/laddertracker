<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersProjection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laddertracker_users', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->primary('id');

            $table->string('display_name');
            $table->integer('bnet_id')->unsigned()->unique();
            $table->string('bnet_url')->unique();

            $table->integer('ladder_rank')->unsigned()->default(201);
            $table->integer('ladder_points')->unsigned();
            $table->integer('hero_points')->unsigned();

            $table->timestamp('hero_points_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('laddertracker_users');
    }
}
