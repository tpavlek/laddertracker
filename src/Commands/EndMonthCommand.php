<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Depotwarehouse\LadderTracker\Database\Month\MonthConstructor;
use Depotwarehouse\LadderTracker\HeroPointIssuerService;

class EndMonthCommand
{

    protected $heroPointIssuerService;
    protected $monthConstructor;

    public function __construct(HeroPointIssuerService $heroPointIssuerService, MonthConstructor $monthConstructor)
    {
        $this->monthConstructor = $monthConstructor;
        $this->heroPointIssuerService = $heroPointIssuerService;
    }

    public function run()
    {
        $this->heroPointIssuerService->endMonth($this->monthConstructor);
    }


}
