<?php

namespace Depotwarehouse\LadderTracker\Commands;

use Depotwarehouse\LadderTracker\Database\User\UserConstructor;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetId;
use Depotwarehouse\LadderTracker\ValueObjects\User\BnetUrl;
use Depotwarehouse\LadderTracker\ValueObjects\User\DisplayName;
use League\Event\Emitter;

class RegisterUserCommand
{

    protected $emitter;
    protected $userConstructor;

    public function __construct(Emitter $emitter, UserConstructor $userConstructor)
    {
        $this->emitter = $emitter;
        $this->userConstructor = $userConstructor;
    }

    public function run(DisplayName $displayName, BnetId $bnetId, BnetUrl $bnetUrl)
    {
        $user = $this->userConstructor->create()
    }



}
