<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

use Depotwarehouse\Blumba\Domain\IdValue;

class BnetId extends IdValue
{

    public function __construct($id)
    {
        if (!is_numeric($id)) {
            throw new \InvalidArgumentException("Bnet ID must be numeric");
        }

        parent::__construct($id);
    }

    public static function fromBnetUrl(BnetUrl $bnetUrl)
    {
        return new static($bnetUrl->getBnetIdSegment());
    }
}
