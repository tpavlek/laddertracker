<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeroPointMonthProjection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hero_points_month', function (Blueprint $table) {
            $table->increments('id');

            $table->string('month_id');
            $table->string('user_id');
            $table->string('display_name');
            $table->integer('hero_points')->unsigned();
            $table->integer('bnet_id')->unsigned();
            $table->string('bnet_url');

            $table->timestamp('end_date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hero_points_month');
    }
}
