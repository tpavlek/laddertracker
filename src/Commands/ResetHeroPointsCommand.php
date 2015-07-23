<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Depotwarehouse\LadderTracker\HeroPointIssuerService;

class ResetHeroPointsCommand
{

    protected $heroPointService;

    public function __construct(HeroPointIssuerService $heroPointService)
    {
        $this->heroPointService = $heroPointService;
    }

    public function run()
    {
        $this->heroPointService->resetPoints();
    }

}
