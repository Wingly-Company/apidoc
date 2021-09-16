<?php

namespace Wingly\ApiDoc\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Group implements ApiDocAttribute
{
    public function __construct(public string $group)
    {
    }
}
