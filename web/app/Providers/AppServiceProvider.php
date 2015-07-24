<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Providers;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ConnectionInterface::class, function() {
            return DB::connection();
        });
    }
}
