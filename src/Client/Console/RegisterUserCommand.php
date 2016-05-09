<?php

namespace Depotwarehouse\LadderTracker\Client\Console;

use Depotwarehouse\LadderTracker\Tracker;
use Depotwarehouse\LadderTracker\ValueObjects\Region;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use League\Event\Emitter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterUserCommand extends Command
{

    protected $internalCommand;

    public function __construct(\Depotwarehouse\LadderTracker\Commands\RegisterUserCommand $internalCommand)
    {
        parent::__construct();
        $this->internalCommand = $internalCommand;
    }

    protected function configure()
    {
        $this->setName('laddertracker:register_user');
        $this->setDescription("Register a user for future tracking within the system");

        $this->addArgument('display_name', InputArgument::REQUIRED, "The user's preferred display name.");
        $this->addArgument('bnet_url', InputArgument::REQUIRED, "The link to the user's battle.net page.");
        $this->addOption('region', 'r', InputOption::VALUE_REQUIRED, "The region the user exists in [na or eu]", \Depotwarehouse\BattleNetSC2Api\Region::America);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $display_name = new DisplayName($input->getArgument('display_name'));
        $bnetUrl = new BnetUrl($input->getArgument('bnet_url'));
        $bnetId = BnetId::fromBnetUrl($bnetUrl);
        $region = new Region($input->getOption('region'));

        $this->internalCommand->register($display_name, $bnetId, $bnetUrl, $region);

        $output->writeln("Registered user {$display_name}!");
    }

}
