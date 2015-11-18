<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\Blumba\Domain\EntityConstructor;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use Depotwarehouse\LadderTracker\ValueObjects\User\UserId;
use function Depotwarehouse\Toolbox\Verification\require_set;

class UserConstructor extends EntityConstructor
{

    public function createInstance(array $attributes)
    {
        if (isset($attributes['user_id'])) {
            $attributes['id'] = $attributes['user_id'];
        }

        require_set($attributes, [ "id", "display_name", "bnet_url", "bnet_id", "hero_points" ]);

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
        $attributes['hero_points'] = new HeroPoints();

        return $this->newUserFromAttributesAndRank($attributes, Rank::userIsNotInGrandmaster());
    }

    protected function newUserFromAttributesAndRank(array $attributes, Rank $rank)
    {

        $user = new User(
            ($attributes['id'] instanceof UserId) ? $attributes['id'] : new UserId($attributes['id']),
            ($attributes['display_name'] instanceof DisplayName) ? $attributes['display_name'] : new DisplayName($attributes['display_name']),
            ($attributes['bnet_id'] instanceof BnetId) ? $attributes['bnet_id'] : new BnetId($attributes['bnet_id']),
            ($attributes['bnet_url'] instanceof BnetUrl) ? $attributes['bnet_url'] : new BnetUrl($attributes['bnet_url']),
            $rank,
            ($attributes['hero_points'] instanceof HeroPoints) ? $attributes['hero_points'] : new HeroPoints($attributes['hero_points'])
        );

        return $user;
    }
}
