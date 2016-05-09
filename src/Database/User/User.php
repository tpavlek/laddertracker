<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\LadderTracker\Database\Entity;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use Depotwarehouse\LadderTracker\ValueObjects\User\UserId;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use League\Url\Url;


class User extends Entity implements Arrayable
{

    protected $id;

    protected $display_name;
    protected $bnet_url;
    protected $bnet_id;

    protected $rank;

    protected $heroPoints;

    protected $region;

    public function __construct(UserId $id, DisplayName $display_name, BnetId $bnet_id, BnetUrl $bnet_url, Rank $rank, HeroPoints $heroPoints, Region $region)
    {
        $this->id = $id;
        $this->display_name = $display_name;
        $this->bnet_id = $bnet_id;
        $this->bnet_url = $bnet_url;
        $this->rank = $rank;
        $this->heroPoints = $heroPoints;
        $this->region = $region;
    }

    /**
     * @return UserId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DisplayName
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * @return BnetUrl
     */
    public function getBnetUrl()
    {
        return $this->bnet_url;
    }

    /**
     * @return BnetId
     */
    public function getBnetId()
    {
        return $this->bnet_id;
    }

    /**
     * @return Rank
     */
    public function getRank()
    {
        return $this->rank;
    }

    public function getHeroPoints()
    {
        return $this->heroPoints;
    }

    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId()->serialize(),
            'display_name' => $this->getDisplayName()->serialize(),
            'bnet_id' => $this->getBnetId()->serialize(),
            'bnet_url' => $this->getBnetUrl()->serialize(),
            'ladder_rank' => $this->getRank()->getLadderRank(),
            'ladder_points' => $this->getRank()->getLadderPoints(),
            'hero_points' => $this->getHeroPoints()->getPoints(),
            'region' => $this->region->toString()
        ];
    }
}
