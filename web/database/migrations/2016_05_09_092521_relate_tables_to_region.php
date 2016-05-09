<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelateTablesToRegion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('laddertracker_users', function (Blueprint $table) {
            $table->string('region')->default('na');
            $table->foreign('region')->references('name')->on('regions');
        });

        \Schema::table('hero_points_month', function (Blueprint $table) {
            $table->string('region')->default('na');
            $table->foreign('region')->references('name')->on('regions');
        });

        \Schema::table('messages', function (Blueprint $table) {
            $table->string('region')->default('na');
            $table->foreign('region')->references('name')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('laddertracker_users', function (Blueprint $table) {

            $table->dropForeign('laddertracker_users_region_foreign');
            $table->dropColumn('region');
        });

        \Schema::table('hero_points_month', function (Blueprint $table) {

            $table->dropForeign('hero_points_month_region_foreign');
            $table->dropColumn('region');
        });

        \Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_region_foreign');
            $table->dropColumn('region');
        });
    }
}
