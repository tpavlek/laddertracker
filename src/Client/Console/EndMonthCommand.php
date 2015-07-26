<?php

namespace Depotwarehouse\LadderTracker\Client\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EndMonthCommand extends Command
{

    public function __construct(\Depotwarehouse\LadderTracker\Commands\EndMonthCommand $internalCommand)
    {
        parent::__construct();
        $this->internalCommand = $internalCommand;
    }

    protected function configure()
    {
        $this->setName("laddertracker:end_month");
        $this->setDescription("Ends a month by archiving the users' hero points, then resetting all user's hero points");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->internalCommand->run();
        $output->writeln("Successfully ended the month!");
    }





}
