<?php

namespace Wingly\ApiDoc;

use ReflectionClass;
use Wingly\ApiDoc\Attributes\ApiDocAttribute;
use Wingly\ApiDoc\Attributes\Authenticated;
use Wingly\ApiDoc\Attributes\Group;

class ClassApiDocAttributes
{
    public function __construct(private ReflectionClass $class)
    {
    }

    public function group(): ?string
    {
        if (! $attribute = $this->getAttribute(Group::class)) {
            return null;
        }

        return $attribute->group;
    }

    public function authenticated(): bool
    {
        if (! $attribute = $this->getAttribute(Authenticated::class)) {
            return false;
        }

        return true;
    }

    protected function getAttribute(string $attributeClass): ?ApiDocAttribute
    {
        $attributes = $this->class->getAttributes($attributeClass);

        if (! count($attributes)) {
            return null;
        }

        return $attributes[0]->newInstance();
    }
}
