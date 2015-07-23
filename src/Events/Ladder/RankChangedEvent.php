<?php

namespace Depotwarehouse\LadderTracker\Events\Ladder;

use Depotwarehouse\LadderTracker\Database\User\User;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use League\Event\AbstractEvent;

class RankChangedEvent extends AbstractEvent implements SerializableEvent
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

    public function getSerialzedPayload()
    {
        return json_encode($this->getPayload());
    }

    public function getPayload()
    {
        return [
            'userId' => (string)$this->user->getId(),
            'difference' => $this->difference()
        ];
    }
}
