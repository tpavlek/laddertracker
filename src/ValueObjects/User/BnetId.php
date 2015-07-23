<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

use Depotwarehouse\LadderTracker\ValueObjects\Contracts\ValueObject;

class BnetId implements ValueObject
{

    protected $bnet_id;

    public static function fromBnetUrl(BnetUrl $bnetUrl)
    {
        return new static($bnetUrl->getBnetIdSegment());
    }

    public function __construct($bnet_id)
    {
        if (!is_numeric($bnet_id)) {
            throw new \InvalidArgumentException("Bnet ID must be numeric");
        }

        $this->bnet_id = $bnet_id;
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->bnet_id;
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function toString()
    {
        return (string)$this->bnet_id;
    }

    public function equals(ValueObject $otherObject)
    {
        if (!$otherObject instanceof BnetId) return false;
        return $this->getId() === $otherObject->getId();
    }
}
