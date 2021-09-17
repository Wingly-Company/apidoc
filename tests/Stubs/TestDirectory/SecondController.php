<?php

namespace Wingly\ApiDoc\Tests\Stubs\TestDirectory;

use Wingly\ApiDoc\Attributes as Doc;

class SecondController
{
    #[Doc\Route(description: 'The second index', method: 'get', uri: '/second-index')]
    public function index()
    {
    }
}
