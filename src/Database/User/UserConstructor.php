<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\LadderTracker\Database\EntityConstructor;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Depotwarehouse\LadderTracker\ValueObjects\User\UserId;
use function Depotwarehouse\Toolbox\Verification\require_set;

class UserConstructor extends EntityConstructor
{

    public function createInstance(array $attributes)
    {
        require_set($attributes, [ "id", "display_name", "bnet_url", "bnet_id" ]);

        if (isset($attributes['ladder_rank']) && isset($attributes['ladder_points'])) {
            $rank = Rank::userIsRankedWithPoints($attributes['ladder_rank'], $attributes['ladder_points']);
        } else {
            $rank = Rank::userIsNotInGrandmaster();
        }

        return $this->newUserFromAttributesAndRank($attributes, $rank);
    }

    public function create(array $attributes)
    {
        require_set($attributes, [ "display_name", "bnet_url", "bnet_id" ]);
        $attributes['id'] = $this->generateId();

        return $this->newUserFromAttributesAndRank($attributes, Rank::userIsNotInGrandmaster());
    }

    protected function newUserFromAttributesAndRank(array $attributes, Rank $rank)
    {
        $user = new User(
            new UserId($attributes['id']),
            new DisplayName($attributes['display_name']),
            new BnetId($attributes['bnet_id']),
            new BnetUrl($attributes['bnet_url']),
            $rank
        );

        return $user;
    }
}
