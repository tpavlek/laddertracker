<?php

namespace Depotwarehouse\LadderTracker\Client\Console;

use Depotwarehouse\LadderTracker\Database\User\UserRepository;
use Depotwarehouse\LadderTracker\ValueObjects\User\HeroPoints;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddHeroPointsCommand extends Command
{

    protected $internalCommand;
    protected $userRepository;

    public function __construct(\Depotwarehouse\LadderTracker\Commands\AddHeroPointsCommand $internalCommand, UserRepository $userRepository)
    {
        parent::__construct();
        $this->internalCommand = $internalCommand;
        $this->userRepository = $userRepository;
    }

    protected function configure()
    {
        $this->setName('laddertracker:add_points');
        $this->setDescription('Add a set number of Hero Points to a particular user account');

        $this->addArgument('user_id', InputArgument::REQUIRED, "The ID of the user Entity");
        $this->addArgument('points', InputArgument::REQUIRED, "The number of points you wish to add");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $userId = $input->getArgument('user_id');
        $pointsToAdd = new HeroPoints($input->getArgument('points'));
        $user = $this->userRepository->find($userId);

        $this->internalCommand->run($user, $pointsToAdd);

        $output->writeln("Added {$pointsToAdd->getPoints()} hero points to {$user->getDisplayName()->toString()}");
    }

}
