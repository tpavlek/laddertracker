<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Http\Controllers;

use Depotwarehouse\LadderTracker\Database\Month\MonthRepository;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;

class HomeController extends Controller
{

    protected $userRepository;
    protected $monthRepository;

    public function __construct(UserRepository $userRepository, MonthRepository $monthRepository)
    {
        $this->userRepository = $userRepository;
        $this->monthRepository = $monthRepository;
    }

    public function index()
    {
        $users = $this->userRepository->top(20, UserRepository::SORT_LADDER_RANK);

        return view('index')->with('users', $users);
    }

    public function about()
    {
        return redirect()->to("http://www.teamliquid.net/forum/sc2-tournaments/487041-na-ladder-heroes");
    }

    public function standings()
    {
        $users = $this->userRepository->top(20, UserRepository::SORT_HERO_POINTS, 'desc', UserRepository::SORT_HERO_POINTS_UPDATE);
        return view('standings')->with('users', $users);
    }

    public function history()
    {
        $months = $this->monthRepository->all();
        return view('history')->with('months', $months);
    }

}
