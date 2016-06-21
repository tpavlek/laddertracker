<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

use Depotwarehouse\Blumba\Domain\ValueObject;
use Depotwarehouse\Blumba\Domain\ValueObjectInterface;

class ClanTag extends ValueObject
{

    protected $clan_tag;

    public function __construct(string $clan_tag)
    {
        $this->clan_tag = $clan_tag;
    }

    public static function noClan()
    {
        return new self("");
    }

    public function exists()
    {
        return !empty($this->clan_tag);
    }

    /**
     * Compare this ValueObject to another of the same type.
     *
     * @param ValueObjectInterface $otherObject
     * @return bool
     */
    protected function equalsSelf(ValueObjectInterface $otherObject)
    {
        return $this->toString() == $otherObject->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        if ($this->exists()) {
            return "[$this->clan_tag]";
        }
        return "";
    }

    public function serialize()
    {
        return $this->clan_tag;
    }
}
