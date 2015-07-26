<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Http\Controllers;

use Depotwarehouse\LadderTracker\Commands\RegisterUserCommand;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(RegisterUserCommand $registerUserCommand, Request $input)
    {
        try {
            $displayName = new DisplayName($input->get('display_name'));
            $bnet_url = new BnetUrl($input->get('bnet_url'));
            $bnet_id = BnetId::fromBnetUrl($bnet_url);

            $registerUserCommand->run($displayName, $bnet_id, $bnet_url);

            return redirect()->route('admin.dashboard')->withErrors(new MessageBag([
                'success' => "Successfully registered {$displayName}"
            ]));

        } catch (\InvalidArgumentException $exception) {
            return redirect()->route('admin.user.create')->withErrors(new MessageBag([
                'errors' => $exception->getMessage()
            ]));
        }


    }

}
