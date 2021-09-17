<?php

namespace Wingly\ApiDoc\Tests\Stubs;

use Wingly\ApiDoc\Attributes as Doc;

class ResponseController
{
    #[Doc\Response()]
    #[Doc\Route(description: 'unique response', method: 'get', uri: '/unique-response')]
    public function index()
    {
    }

    #[Doc\Response()]
    #[Doc\Response(status: 404, scenario: 'Not Found')]
    #[Doc\Route(description: 'many responses', method: 'get', uri: '/many-responses')]
    public function show()
    {
    }
}
