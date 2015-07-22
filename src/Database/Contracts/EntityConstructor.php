<?php

namespace Depotwarehouse\LadderTracker\Database\Contracts;

interface EntityConstructor
{

    public function createInstance(array $attributes);

    public function create(array $attributes);

}
