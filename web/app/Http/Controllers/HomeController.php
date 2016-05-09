<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Http\Controllers;

use Depotwarehouse\LadderTracker\Database\MessageRecord;
use Depotwarehouse\LadderTracker\Database\Month\MonthRepository;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\ValueObjects\Region;

class HomeController extends Controller
{

    protected $userRepository;
    protected $monthRepository;
    protected $messages;

    public function __construct(UserRepository $userRepository, MonthRepository $monthRepository, MessageRecord $messages)
    {
        $this->userRepository = $userRepository;
        $this->monthRepository = $monthRepository;
        $this->messages = $messages;
    }

    public function index()
    {
        $naUsers = $this->userRepository->top(25, Region::america(), UserRepository::SORT_LADDER_RANK);
        $euUsers = $this->userRepository->top(25, Region::europe(), UserRepository::SORT_LADDER_RANK);

        return view('index')
            ->with('naUsers', $naUsers)
            ->with('euUsers', $euUsers)
            ->with('message', $this->messages->latest());
    }

    public function about()
    {
        return redirect()->to("http://www.teamliquid.net/forum/sc2-tournaments/487041-na-ladder-heroes");
    }

    public function standings()
    {
        // TODO standings per region
        $users = $this->userRepository->top(20, UserRepository::SORT_HERO_POINTS, 'desc', UserRepository::SORT_HERO_POINTS_UPDATE);
        return view('standings')->with('users', $users);
    }

    public function history()
    {
        $months = $this->monthRepository->all();
        return view('history')->with('months', $months);
    }

}
