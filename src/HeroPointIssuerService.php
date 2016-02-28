<?php

namespace Depotwarehouse\LadderTracker;

use Depotwarehouse\LadderTracker\Database\Month\MonthConstructor;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\Events\Heroes\MonthWasEndedEvent;
use Depotwarehouse\LadderTracker\Events\Heroes\HeroPointsChangedEvent;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use League\Event\Emitter;

class HeroPointIssuerService
{

    const NUM_PLAYERS_AWARD_TO = 20;

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
        foreach ($this->userRepository->top(self::NUM_PLAYERS_AWARD_TO) as $user) {
            /** @var User $user */
            if (!$user->getRank()->isGrandmaster()) {
                // We've exhausted the list of grandmaster level players, so we're done.
                return;
            }
            $points = new HeroPoints($this->getPointsForPlacing($i));
            $this->emitter->emit(new HeroPointsChangedEvent($user, $points));

            $i++;
        }
    }

    public function resetPoints()
    {
        foreach($this->userRepository->all() as $user) {
            /** @var User $user */
            if ($user->getHeroPoints()->getPoints() > 0) {
                $this->emitter->emit(new HeroPointsChangedEvent($user, $user->getHeroPoints()->invert()));
            }
        }
    }

    public function endMonth(MonthConstructor $monthConstructor)
    {
        $users = $this->userRepository->all();

        // We only want to serialize users that have any hero points.
        $users = $users->filter(function (User $user) {
            return $user->getHeroPoints()->any();
        });

        $month = $monthConstructor->create([ 'users' => $users ]);

        $this->emitter->emit(new MonthWasEndedEvent($month));
        $this->resetPoints();
    }

    private function getPointsForPlacing($placement)
    {

        $placements = [
            1 => 23,
            2 => 21,
            3 => 20,
            4 => 19,
            5 => 17,
            6 => 16,
            7 => 15,
            8 => 14,
            9 => 12,
            10 => 11,
            11 => 10,
            12 => 9,
            13 => 8,
            14 => 7,
            15 => 6,
            16 => 5,
            17 => 4,
            18 => 3,
            19 => 2,
            20 => 1,
        ];

        return (isset($placements[$placement])) ? $placements[$placement] : 0;
    }
}
