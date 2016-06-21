<?php

namespace Depotwarehouse\LadderTracker\Events\User;

use Depotwarehouse\Blumba\EventSourcing\SerializableEvent;
use Depotwarehouse\LadderTracker\ValueObjects\User\ClanTag;
use Depotwarehouse\LadderTracker\ValueObjects\User\UserId;

class ClanTagChangedEvent extends SerializableEvent
{

    /**
     * @var UserId
     */
    private $userId;
    /**
     * @var ClanTag
     */
    private $newClanTag;

    public function __construct(UserId $userId, ClanTag $newClanTag)
    {

        $this->userId = $userId;
        $this->newClanTag = $newClanTag;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'user_id' => $this->userId->serialize(),
            'clan_tag' => $this->newClanTag->serialize()
        ];
    }

    /**
     * @return string
     */
    public function getAggregateId()
    {
        return $this->userId->serialize();
    }
}
