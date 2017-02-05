<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Http\Controllers;

use Depotwarehouse\LadderTracker\Commands\RegisterUserCommand;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\MessageBag;
use URL;

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

    public function listUsers(UserRepository $userRepository, Request $request)
    {
        $users = $userRepository->all();

        return view('user.list')->with('users', $users);

    }

    public function store(RegisterUserCommand $registerUserCommand, Request $input)
    {
        try {
            $displayName = new DisplayName($input->get('display_name'));
            $bnet_url = new BnetUrl($input->get('bnet_url'));
            $bnet_id = BnetId::fromBnetUrl($bnet_url);
            $region = new Region($input->get('region'));
            $paypal = (string) $input->get('paypal');

            $registerUserCommand->register($displayName, $bnet_id, $bnet_url, $region, $paypal);

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
