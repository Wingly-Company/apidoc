<?php

namespace Wingly\ApiDoc\Tests\Stubs;

use Wingly\ApiDoc\Attributes as Doc;

class NoGroupController
{
    #[Doc\Route(description: 'not grouped', method: 'get', uri: '/not-grouped')]
    public function index()
    {
    }
}
