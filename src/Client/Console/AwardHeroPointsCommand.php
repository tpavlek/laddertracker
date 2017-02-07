<?php

namespace Depotwarehouse\LadderTracker\Client\Console;

use Carbon\Carbon;
use Depotwarehouse\BattleNetSC2Api\Region;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class AwardHeroPointsCommand extends Command
{

    private $internalCommand;

    public function __construct(\Depotwarehouse\LadderTracker\Commands\AwardHeroPointsCommand $internalCommand)
    {
        parent::__construct();
       $this->internalCommand = $internalCommand;
    }

    public function configure()
    {
        $this->setName('laddertracker:award');
        $this->addArgument('region', InputArgument::REQUIRED, 'na or eu');
        $this->setDescription('Award hero points to all users that deserve them');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $date = Carbon::now()->toDateTimeString();
        $region = $input->getArgument('region') == 'na' ?
            \Depotwarehouse\LadderTracker\ValueObjects\Region::america() :
            \Depotwarehouse\LadderTracker\ValueObjects\Region::europe();
        $this->internalCommand->run($region);
        $output->writeln("[$date] Awarded hero points to all users in region " . $region);
    }

}
