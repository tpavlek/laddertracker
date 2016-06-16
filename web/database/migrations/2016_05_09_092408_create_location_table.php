<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('regions', function (Blueprint $table) {
            $table->string('name');

            $table->primary('name');
        });

        \DB::table('regions')->insert([ [ 'name' => \Depotwarehouse\BattleNetSC2Api\Region::America ], [ 'name' => \Depotwarehouse\BattleNetSC2Api\Region::Europe ] ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('regions');
    }
}
