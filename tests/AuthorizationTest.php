<?php

namespace Wingly\ApiDoc\Tests;

use Wingly\ApiDoc\AuthorizesRequests;

class AuthorizationTest extends TestCase
{
    public function test_authorization_callback_is_executed()
    {
        AuthorizesRequests::auth(function ($request) {
            return $request;
        });

        $this->assertEquals('Dimi', AuthorizesRequests::check('Dimi'));
    }
}
