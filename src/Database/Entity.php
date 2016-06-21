<?php

namespace Depotwarehouse\LadderTracker\Database;

abstract class Entity implements \Depotwarehouse\LadderTracker\Database\Contracts\Entity
{

    private function getMethodNameFromSnakeAttribute($attribute)
    {
        // We assume the method name is getPascalCasedAtrributeName
        $methodName = "get" . ucfirst(camel_case($attribute));

        return $methodName;
    }

    public function __isset($attribute)
    {
        $methodName = $this->getMethodNameFromSnakeAttribute($attribute);

        return (method_exists($this, $methodName));
    }

    public function __get($attribute)
    {
        $methodName = $this->getMethodNameFromSnakeAttribute($attribute);

        if (method_exists($this, $methodName)) {
            return (string)$this->{$methodName}();
        }

        return null;
    }

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
