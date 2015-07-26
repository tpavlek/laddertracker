<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Http\Controllers;

use Depotwarehouse\LadderTracker\Commands\UpdateFromBnetCommand;
use Illuminate\Support\MessageBag;

class LadderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update()
    {
        return view('ladder.update');
    }

    public function resync(UpdateFromBnetCommand $updateFromBnetCommand)
    {
        $updateFromBnetCommand->run();

        return redirect()->route('admin.dashboard')->withErrors(new MessageBag([
            'success' => 'Successfully updated scores from Battle.net'
        ]));
    }

}
