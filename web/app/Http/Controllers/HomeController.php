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

        $naUsers = $this->userRepository->top(25, Region::america(), UserRepository::SORT_LADDER_POINTS, 'DESC');
        $euUsers = $this->userRepository->top(25, Region::europe(), UserRepository::SORT_LADDER_POINTS, 'DESC');

        return view('index')
            ->with('naUsers', $naUsers)
            ->with('euUsers', $euUsers)
            ->with('naMessage', $this->messages->latest(Region::america()))
            ->with('euMessage', $this->messages->latest(Region::europe()));
    }

    public function about_na()
    {
        return redirect()->to("http://www.teamliquid.net/forum/sc2-tournaments/487041-na-ladder-heroes");
    }

    public function about_eu()
    {
        return redirect()->to("http://www.teamliquid.net/forum/sc2-tournaments/510361-eu-ladder-heroes");
    }

    public function standings($region)
    {
        $region = new Region($region);
        $users = $this->userRepository->top(20, $region, UserRepository::SORT_HERO_POINTS, 'desc', UserRepository::SORT_HERO_POINTS_UPDATE);
        return view('standings')
            ->with('users', $users)
            ->with('region', $region);
    }

    public function history()
    {
        $months = $this->monthRepository->all();
        return view('history')->with('months', $months);
    }

}
