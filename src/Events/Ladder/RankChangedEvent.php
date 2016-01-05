<?php

namespace Depotwarehouse\LadderTracker\Events\Ladder;

use Depotwarehouse\Blumba\EventSourcing\SerializableEvent;
use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;

class RankChangedEvent extends SerializableEvent
{

    protected $user;
    protected $newRank;

    public function __construct(User $user, Rank $newRank)
    {
        $this->user = $user;
        $this->newRank = $newRank;
    }

    public function getAggregateId()
    {
        return (string)$this->user->getId();
    }


    /**
     * Get the difference in the user's current rank vs. their new rank.
     *
     * @return int
     */
    public function difference()
    {
        return $this->user->getRank()->differenceLadderRank($this->newRank);
    }

    public function getPayload()
    {
        return [
            'userId' => (string)$this->user->getId(),
            'difference' => $this->difference()
        ];
    }
}
