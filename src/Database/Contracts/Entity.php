<?php

namespace Depotwarehouse\LadderTracker\Database\Contracts;

interface Entity
{
    public function equals(\Depotwarehouse\LadderTracker\Database\Contracts\Entity $otherEntity);

    public function getId();
}
