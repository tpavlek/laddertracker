<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Depotwarehouse\LadderTracker\HeroPointIssuerService;
use Depotwarehouse\LadderTracker\ValueObjects\Region;

class AwardHeroPointsCommand
{

    protected $heroPointIssuerService;

    public function __construct(HeroPointIssuerService $heroPointIssuerService)
    {
        $this->heroPointIssuerService = $heroPointIssuerService;
    }

    public function run(Region $region)
    {
        $this->heroPointIssuerService->awardPoints($region);
    }
}
