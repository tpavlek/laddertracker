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

        $this->command->info("Seeded initial admin user!");

        DB::table('regions')->insert([
            [ 'name' => \Depotwarehouse\BattleNetSC2Api\Region::America ],
            [ 'name' => \Depotwarehouse\BattleNetSC2Api\Region::Europe ]
        ]);

        $this->command->info("Seeded Europe and America Regions!");

        Model::reguard();
    }
}
