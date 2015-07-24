<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \Depotwarehouse\LadderTracker\Client\Web\Http\Auth\AuthenticatedUser::create([
            'id' => 1,
            'username' => 'admin'
        ]);

        Model::reguard();
    }
}
