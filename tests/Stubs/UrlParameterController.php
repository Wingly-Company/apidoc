<?php

namespace Wingly\ApiDoc\Tests\Stubs;

use Wingly\ApiDoc\Attributes as Doc;

class UrlParameterController
{
    #[Doc\UrlParameter(name: 'id', type: 'integer', description: 'The id', required: true)]
    #[Doc\Route(description: 'unique parameter', method: 'get', uri: '/url-parameter')]
    public function index()
    {
    }

    #[Doc\UrlParameter(name: 'id', type: 'integer', description: 'The id', required: true)]
    #[Doc\UrlParameter(name: 'slug', type: 'string', description: 'The slug')]
    #[Doc\Route(description: 'many parameters', method: 'get', uri: '/many-parameters')]
    public function show()
    {
    }
}
