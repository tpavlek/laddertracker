<?php

namespace Depotwarehouse\LadderTracker\Client\Console;

use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateFromBnetCommand extends Command
{

    protected $internalCommand;

    public function __construct(\Depotwarehouse\LadderTracker\Commands\UpdateFromBnetCommand $internalCommand)
    {
        parent::__construct();

        $this->internalCommand = $internalCommand;
    }

    public function configure()
    {
        $this->setName("laddertracker:update_all");
        $this->setDescription("Update the ladder rank of all users in the system, based on the Battle.net API");
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $date = Carbon::now()->toDateTimeString();

        $output->writeln("[$date] Querying and updating from the Battle.net API...");
        $this->internalCommand->run();

        $date = Carbon::now()->toDateTimeString();
        $output->writeln("[$date] Updated!");
    }

}
