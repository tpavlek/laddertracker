<?php

namespace Depotwarehouse\LadderTracker;

use Depotwarehouse\LadderTracker\Database\Month\MonthConstructor;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\Events\Heroes\EndMonthEvent;
use Depotwarehouse\LadderTracker\Events\Heroes\HeroPointChangedEvent;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use League\Event\Emitter;

class HeroPointIssuerService
{

    protected $userRepository;
    protected $emitter;

    public function __construct(UserRepository $userRepository, Emitter $emitter)
    {
        $this->userRepository = $userRepository;
        $this->emitter = $emitter;
    }

    public function awardPoints()
    {
        $i = 1;
        foreach ($this->userRepository->top(16) as $user) {
            /** @var User $user */
            if (!$user->getRank()->isGrandmaster()) {
                // We've exhausted the list of grandmaster level players, so we're done.
                return;
            }
            $points = new HeroPoints($this->getPointsForPlacing($i));
            $this->emitter->emit(new HeroPointChangedEvent($user, $points));

            $i++;
        }
    }

    public function resetPoints()
    {
        foreach($this->userRepository->all() as $user) {
            /** @var User $user */
            if ($user->getHeroPoints()->getPoints() > 0) {
                $this->emitter->emit(new HeroPointChangedEvent($user, $user->getHeroPoints()->getInverse()));
            }
        }
    }

    public function endMonth(MonthConstructor $monthConstructor)
    {
        $users = $this->userRepository->top(16);

        // We only want to serialize users that have any hero points.
        $users = $users->filter(function (User $user) {
            return $user->getHeroPoints()->any();
        });

        $month = $monthConstructor->create([ 'users' => $users ]);

        $this->emitter->emit(new EndMonthEvent($month));
        $this->resetPoints();
    }

    private function getPointsForPlacing($placement)
    {
        switch ($placement) {
            case 1:
                return 19;
                break;
            case 2:
                return 17;
                break;
            case 3:
                return 16;
                break;
            case 4:
                return 15;
                break;
            case 5:
                return 14;
                break;
            case 6:
                return 12;
                break;
            case 7:
                return 11;
                break;
            case 8:
                return 10;
                break;
            case 9:
                return 8;
                break;
            case 10:
                return 7;
                break;
            case 11:
                return 6;
                break;
            case 12:
                return 5;
                break;
            case 13:
                return 4;
                break;
            case 14:
                return 3;
                break;
            case 15:
                return 2;
                break;
            case 16:
                return 1;
                break;
            default:
                return 0;
                break;
        }

    }

}
