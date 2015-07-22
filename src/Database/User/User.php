<?php

namespace Depotwarehouse\LadderTracker\Database\User;

use Depotwarehouse\LadderTracker\Database\Entity;
use Depotwarehouse\LadderTracker\ValueObjects\Ladder\Rank;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use Depotwarehouse\LadderTracker\ValueObjects\User\UserId;
use Illuminate\Database\Eloquent\Model;
use League\Url\Url;


class User extends Entity
{

    protected $id;

    protected $display_name;
    protected $bnet_url;
    protected $bnet_id;

    protected $rank;

    public function __construct(UserId $id, DisplayName $display_name, BnetId $bnet_id, BnetUrl $bnet_url, Rank $rank)
    {
        $this->id = $id;
        $this->display_name = $display_name;
        $this->bnet_id = $bnet_id;
        $this->bnet_url = $bnet_url;
        $this->rank = $rank;
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
}
