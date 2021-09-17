<?php

namespace Wingly\ApiDoc\Tests\Stubs\TestDirectory;

use Wingly\ApiDoc\Attributes as Doc;

class FirstController
{
    #[Doc\Route(description: 'The first index', method: 'get', uri: '/first-index')]
    public function index()
    {
    }
}
