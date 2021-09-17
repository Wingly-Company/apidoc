<?php

namespace Wingly\ApiDoc\Tests\Stubs;

use Wingly\ApiDoc\Attributes as Doc;

class RouteController
{
    #[Doc\Route(description: 'route', method: 'get', uri: '/route')]
    public function index()
    {
    }
}
