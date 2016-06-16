<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Depotwarehouse\LadderTracker\Database\Month\MonthConstructor;
use Depotwarehouse\LadderTracker\HeroPointIssuerService;
use Depotwarehouse\LadderTracker\ValueObjects\Region;

class EndMonthCommand
{

    protected $heroPointIssuerService;
    protected $monthConstructor;

    public function __construct(HeroPointIssuerService $heroPointIssuerService, MonthConstructor $monthConstructor)
    {
        $this->monthConstructor = $monthConstructor;
        $this->heroPointIssuerService = $heroPointIssuerService;
    }

    public function run(Region $region)
    {
        $this->heroPointIssuerService->endMonth($this->monthConstructor, $region);
    }


}
