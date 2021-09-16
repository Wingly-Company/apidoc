<?php

namespace Wingly\ApiDoc\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Response implements ApiDocAttribute
{
    public function __construct(
        public int $status = 200,
        public string $scenario = 'Success',
        public mixed $example = null
    ) {
    }
}
