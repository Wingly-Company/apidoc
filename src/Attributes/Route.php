<?php

namespace Wingly\ApiDoc\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Route implements ApiDocAttribute
{
    public function __construct(
        public string $description,
        public string $uri,
        public string $method,
    ) {
    }
}
