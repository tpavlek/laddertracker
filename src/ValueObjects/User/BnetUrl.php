<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

use Depotwarehouse\LadderTracker\ValueObjects\Contracts\ValueObject;
use League\Url\Url;

class BnetUrl implements ValueObject
{

    protected $bnetUrl;

    public function __construct($bnet_url)
    {
        // todo some more advanced validation of the URL.

        $bnet_url = filter_var($bnet_url, FILTER_VALIDATE_URL);

        if ($bnet_url === false) {
            throw new \InvalidArgumentException("BNet URL must be a valid URL");
        }

        $this->bnet_url = $bnet_url;
    }

    /**
     * Get the Battle.net ID segment from the battle.net URL.
     *
     * @return int|string
     * @throws \Exception
     */
    public function getBnetIdSegment()
    {
        $path = explode("/", Url::createFromUrl($this->bnet_url)->getPath());

        if (count($path) < 4) {
            // TODO custom exception type here.
            throw new \Exception("The battle.net URL {$this->bnet_url} does not seem to contain an ID segment");
        }

        return $path[3];
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function toString()
    {
        return (string)$this->bnet_url;
    }

    public function equals(ValueObject $otherObject)
    {
        return $this->toString() === $otherObject->toString();
    }
}
