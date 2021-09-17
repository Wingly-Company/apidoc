<?php

namespace Wingly\ApiDoc\Tests\Stubs;

use Wingly\ApiDoc\Attributes as Doc;

#[Doc\Group('Grouped')]
class GroupController
{
    #[Doc\Route(description: 'grouped', method: 'get', uri: '/grouped')]
    public function index()
    {
    }
}
