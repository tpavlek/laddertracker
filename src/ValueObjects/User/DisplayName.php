<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

class DisplayName
{

    protected $display_name;

    public function __construct($display_name)
    {
        $this->display_name = $display_name;
    }

    public function __toString()
    {
        return $this->display_name;
    }

}
