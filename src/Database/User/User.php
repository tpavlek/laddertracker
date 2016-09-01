<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Database\Entity;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\ClanTag;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use Depotwarehouse\LadderTracker\ValueObjects\User\UserId;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use League\Url\Url;


class User extends Entity implements Arrayable
{

    protected $id;

    protected $clan_tag;
    protected $display_name;
    protected $bnet_url;
    protected $bnet_id;

    protected $rank;

    protected $heroPoints;

    protected $region;

    protected $lastPlayed;

    public function __construct(UserId $id, ClanTag $clanTag, DisplayName $display_name, BnetId $bnet_id, BnetUrl $bnet_url, Rank $rank, HeroPoints $heroPoints, Region $region, Carbon $lastPlayed = null)
    {
        $this->id = $id;
        $this->clan_tag = $clanTag;
        $this->display_name = $display_name;
        $this->bnet_id = $bnet_id;
        $this->bnet_url = $bnet_url;
        $this->rank = $rank;
        $this->heroPoints = $heroPoints;
        $this->region = $region;

        if ($lastPlayed === null) {
            $lastPlayed = Carbon::now();
        }

        $this->lastPlayed = $lastPlayed;
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
    public function getDisplayName() : DisplayName
    {
        if ($this->getClanTag()->exists()) {
            return new DisplayName($this->getClanTag() . " " . $this->display_name);
        }

        return $this->display_name;
    }

    /**
     * @return BnetUrl
     */
    public function getBnetUrl() : BnetUrl
    {
        return $this->bnet_url;
    }

    /**
     * @return BnetId
     */
    public function getBnetId() : BnetId
    {
        return $this->bnet_id;
    }

    /**
     * @return Rank
     */
    public function getRank() : Rank
    {
        return $this->rank;
    }

    public function getHeroPoints() : HeroPoints
    {
        return $this->heroPoints;
    }

    public function getRegion() : Region
    {
        return $this->region;
    }

    public function getClanTag() : ClanTag
    {
        return $this->clan_tag;
    }

    public function lastPlayed() : Carbon
    {
        return $this->lastPlayed;
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
