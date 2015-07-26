<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Providers;

use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\Tracker;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\ServiceProvider;
use DB;
use League\Event\Emitter;

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

        $emitter = new Emitter();
        $tracker = new Tracker($this->app->make(ConnectionInterface::class), $emitter);

        // We want a single emitter class for our whole application.
        $this->app->instance(Emitter::class, $emitter);
        $this->app->instance(Tracker::class, $tracker);
    }
}
