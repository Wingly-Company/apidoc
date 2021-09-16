<?php

namespace Wingly\ApiDoc\Attributes;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD)]
class UrlParameter extends Parameter
{
}
