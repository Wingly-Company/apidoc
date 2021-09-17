<?php

namespace Wingly\ApiDoc\Attributes;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD)]
class Parameter implements ApiDocAttribute
{
    public function __construct(
        public string $name,
        public string $type,
        public string $description,
        public bool $required = false
    ) {
    }
}
