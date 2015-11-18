<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\Messaging;

use Depotwarehouse\Blumba\Domain\DateTimeValue;
use Depotwarehouse\Blumba\Domain\ValueObject;
use Depotwarehouse\Blumba\Domain\ValueObjectInterface;

class Message extends ValueObject
{

    protected $message;
    protected $expires;

    public function __construct($message, DateTimeValue $expires)
    {
        $this->message = $message;
        $this->expires = $expires;
    }

    public static function emptyMessage()
    {
        return new self("", DateTimeValue::now());
    }

    /**
     * Compare this ValueObject to another of the same type.
     *
     * @param ValueObjectInterface $otherObject
     * @return bool
     */
    protected function equalsSelf(ValueObjectInterface $otherObject)
    {
        return $this->toString() === $otherObject->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (string)$this->message;
    }

    public function isEmpty()
    {
        return empty(trim($this->message));
    }

    public function expiry()
    {
        return $this->expires;
    }
}
