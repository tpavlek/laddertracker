<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClanTagToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('laddertracker_users', function (Blueprint $table) {
            $table->string('clan_tag');
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
            $table->dropColumn('clan_tag');
        });
    }
}
