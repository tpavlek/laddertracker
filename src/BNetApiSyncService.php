<?php

namespace Depotwarehouse\LadderTracker;

use Depotwarehouse\BattleNetSC2Api\ApiService;
use Depotwarehouse\BattleNetSC2Api\Entity\Grandmaster\Player;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\Events\Ladder\PointsChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\RankChangedEvent;
use Depotwarehouse\LadderTracker\Events\Ladder\UserDroppedOutOfGrandmasterEvent;
use Depotwarehouse\LadderTracker\Events\User\ClanTagChangedEvent;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\ValueObjects\User\ClanTag;
use Illuminate\Support\Collection;
use League\Event\Emitter;

class BNetApiSyncService
{

    protected $userRepository;
    protected $apiService;
    protected $emitter;

    public function __construct(UserRepository $userRepository, ApiService $apiService, Emitter $emitter)
    {
        $this->userRepository = $userRepository;
        $this->apiService = $apiService;
        $this->emitter = $emitter;
    }

    public function update(Region $region)
    {
        $playerList = $this->userRepository->region($region);

        foreach ($this->apiService->getGrandmasterInformation() as $grandmasterPlayer) {

            /** @var Player $grandmasterPlayer */

            $matched_player = $this->popLocallyTrackedPlayerFromCollection($playerList, $grandmasterPlayer);

            if ($matched_player !== null) {
                $grandmasterPlayerRank = Rank::userIsRankedWithPoints($grandmasterPlayer->getCurrentRank(), $grandmasterPlayer->getPoints());

                // Has the user's points differed from our locally tracked version?
                if (!$matched_player->getRank()->pointsEquals($grandmasterPlayerRank)) {
                    $this->emitter->emit(new PointsChangedEvent($matched_player, $grandmasterPlayerRank));
                }

                // Has the user's rank differed from our locally tracked version?
                if (!$matched_player->getRank()->rankEquals($grandmasterPlayerRank)) {
                    $this->emitter->emit(new RankChangedEvent($matched_player, $grandmasterPlayerRank));
                }

                // Has the user's clan tag changed?
                if ($matched_player->getClanTag()->serialize() != "{$grandmasterPlayer->getClanTag()}") {
                    $this->emitter->emit(new ClanTagChangedEvent($matched_player->getId(), new ClanTag($grandmasterPlayer->getClanTag())));
                }
            }
        }

        // If there are any players left in our player list, than those players are no longer in grandmaster.
        if ($playerList->count()) {
            foreach ($playerList as $player) {
                /** @var User $player */

                if ($player->getRank()->isGrandmaster()) {
                    $this->emitter->emit(new UserDroppedOutOfGrandmasterEvent($player));
                }
            }
        }
    }

    /**
     * @param Collection $localCollection
     * @param Player $grandmasterPlayer
     * @return User|null
     */
    private function popLocallyTrackedPlayerFromCollection(Collection &$localCollection, Player $grandmasterPlayer)
    {
        $matched_player = $localCollection->first(function ($key, User $localUser) use ($grandmasterPlayer) {
            return $localUser->getBnetId()->toString() == $grandmasterPlayer->getId();
        });

        if ($matched_player !== null) {
            $localCollection = $localCollection->reject(function (User $value) use ($grandmasterPlayer) {
                return $value->getBnetId()->toString() == $grandmasterPlayer->getId();
            });
        }

        return $matched_player;
    }

}
