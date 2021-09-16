<?php

namespace Wingly\ApiDoc\Tests\Stubs;

use Wingly\ApiDoc\Attributes as Doc;

#[Doc\Group('Test group')]
class ControllerWithGroup
{
    #[Doc\Route(description: 'The index method', method: 'get', uri: '/api/group')]
    public function index()
    {
    }

    #[Doc\Route(description: 'The show method', method: 'get', uri: '/api/group/{id}')]
    public function show()
    {
    }
}
