<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Http\Controllers;

use Depotwarehouse\LadderTracker\Database\User\UserRepository;

class HomeController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->top(20);

        return view('index')->with('users', $users);
    }

    public function about()
    {
        return view('about');
    }

    public function standings()
    {
        $users = $this->userRepository->top(20, UserRepository::SORT_HERO_POINTS);
        return view('standings')->with('users', $users);
    }

}
