<?php

namespace Depotwarehouse\LadderTracker\Database;

use Rhumsaa\Uuid\Uuid;

abstract class Entity implements \Depotwarehouse\LadderTracker\Database\Contracts\Entity
{

    public function equals(\Depotwarehouse\LadderTracker\Database\Contracts\Entity $otherEntity)
    {
        return $this->getId() === $otherEntity->getId();
    }

    protected function fillFromArray($attributesToFill, array $attributes)
    {
        if (!is_array($attributesToFill)) {
            $this->{$attributesToFill} = $attributes[$attributesToFill];
            return;
        }

        foreach ($attributesToFill as $attributeToFill) {
            $this->{$attributeToFill} = $attributes[$attributeToFill];
        }
    }


}
