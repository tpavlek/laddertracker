<?php

namespace Depotwarehouse\LadderTracker\ValueObjects\User;

class BnetUrl
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

    public function __toString()
    {
        return $this->bnet_url;
    }

}
