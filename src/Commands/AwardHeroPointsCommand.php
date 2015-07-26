<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Depotwarehouse\LadderTracker\HeroPointIssuerService;

class AwardHeroPointsCommand
{

    protected $heroPointIssuerService;

    public function __construct(HeroPointIssuerService $heroPointIssuerService)
    {
        $this->heroPointIssuerService = $heroPointIssuerService;
    }

    public function run()
    {
        $this->heroPointIssuerService->awardPoints();
    }

}
