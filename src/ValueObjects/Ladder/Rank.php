<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\Ladder;

use Depotwarehouse\LadderTracker\ValueObjects\Contracts\ValueObject;

class Rank implements ValueObject
{

    const NOT_IN_GRANDMASTER_LADDER_RANK = 201;
    const NOT_IN_GRANDMASTER_LADDER_POINTS = 0;

    protected $rank;
    protected $points;

    public function __construct($rank, $points)
    {
        $this->rank = $rank;
        $this->points = $points;
    }

    public static function userIsNotInGrandmaster()
    {
        $rank = new Rank(static::NOT_IN_GRANDMASTER_LADDER_RANK, static::NOT_IN_GRANDMASTER_LADDER_POINTS);
        return $rank;
    }

    public static function userIsRankedWithPoints($ladder_rank, $num_points)
    {
        $rank = new Rank($ladder_rank, $num_points);
        return $rank;
    }

    public function getLadderRank()
    {
        return $this->rank;
    }

    public function getLadderPoints()
    {
        return $this->points;
    }

    public function equals(ValueObject $otherObject)
    {
        /** @var Rank $otherObject */
        return $this->getLadderRank() === $otherObject->getLadderRank() && $this->getLadderPoints() === $otherObject->getLadderPoints();
    }

    public function pointsEquals(Rank $otherRank)
    {
        return $this->getLadderPoints() === $otherRank->getLadderPoints();
    }

    public function rankEquals(Rank $otherRank)
    {
        return $this->getLadderRank() === $otherRank->getLadderRank();
    }

    public function differenceLadderRank(Rank $otherRank)
    {
        return $this->getLadderRank() - $otherRank->getLadderRank();
    }

    public function differenceLadderPoints(Rank $otherRank)
    {
        return $otherRank->getLadderPoints() - $this->getLadderPoints();
    }
}
