<?php

namespace Wingly\ApiDoc\Tests\Stubs;

use Wingly\ApiDoc\Attributes as Doc;

#[Doc\Authenticated]
class AuthenticatedController
{
    #[Doc\Route(description: 'authenticated', method: 'get', uri: 'authenticated')]
    public function index()
    {
    }
}
