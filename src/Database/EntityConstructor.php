<?php

namespace Depotwarehouse\LadderTracker\Database;

use Rhumsaa\Uuid\Uuid;

abstract class EntityConstructor implements \Depotwarehouse\LadderTracker\Database\Contracts\EntityConstructor
{

    protected function generateId()
    {
        return Uuid::uuid4()->toString();
    }


}
