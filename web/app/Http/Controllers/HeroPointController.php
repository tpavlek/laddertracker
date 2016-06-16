<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Http\Controllers;

use Depotwarehouse\LadderTracker\Commands\AddHeroPointsCommand;
use Depotwarehouse\LadderTracker\Commands\AwardHeroPointsCommand;
use Depotwarehouse\LadderTracker\Commands\EndMonthCommand;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class HeroPointController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showAwardForm()
    {

        return view('hero_points.award');
    }

    public function award(AwardHeroPointsCommand $awardHeroPointsCommand, Request $input)
    {
        $region = new Region($input->get('region'));
        $awardHeroPointsCommand->run($region);

        return redirect()->route('admin.dashboard')->withErrors(new MessageBag([
            'success' => "Hero Points awarded for {$region->niceString()}! See you next week!"
        ]));
    }

    public function add(UserRepository $userRepository) {
        $userList = $userRepository->all()->pluck('display_name', 'id');

        return view('hero_points.add')->with('userList', $userList);
    }

    public function update(UserRepository $userRepository, AddHeroPointsCommand $addHeroPointsCommand, Request $input)
    {
        $user = $userRepository->find($input->get('user_id'));
        $pointsToAdd = new HeroPoints($input->get('difference'));
        $addHeroPointsCommand->run($user, $pointsToAdd);

        return redirect()->route('admin.dashboard')->withErrors(new MessageBag([
            'success' => "Added {$pointsToAdd} hero points to {$user->getDisplayName()}"
        ]));
    }

    public function showEndMonthForm()
    {
        return view('hero_points.end_month');
    }

    public function endMonth(EndMonthCommand $endMonthCommand, Request $input)
    {
        $region = new Region($input->get('region'));
        $endMonthCommand->run($region);

        return redirect()->route('admin.dashboard')->withErrors(new MessageBag([
            'success' => "Month has ended for {$region->niceString()}! See you next month!"
        ]));
    }

}
