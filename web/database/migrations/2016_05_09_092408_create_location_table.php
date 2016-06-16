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

        \DB::table('regions')->insert([ [ 'name' => 'na' ], [ 'name' => 'eu'] ]);
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
