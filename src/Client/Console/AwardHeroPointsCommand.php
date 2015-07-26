<?php

namespace Depotwarehouse\LadderTracker\Client\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AwardHeroPointsCommand extends Command
{

    public function __construct(\Depotwarehouse\LadderTracker\Commands\AwardHeroPointsCommand $internalCommand)
    {
        parent::__construct();
       $this->internalCommand = $internalCommand;
    }

    public function configure()
    {
        $this->setName('laddertracker:award');
        $this->setDescription('Award hero points to all users that deserve them');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->internalCommand->run();
        $output->writeln("Awarded hero points to all users!");
    }

}
