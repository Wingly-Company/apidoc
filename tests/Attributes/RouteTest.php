<?php

namespace Wingly\ApiDoc\Tests\Attributes;

use Wingly\ApiDoc\DocumentationGenerator;
use Wingly\ApiDoc\Tests\Stubs\RouteController;
use Wingly\ApiDoc\Tests\TestCase;

class RouteTest extends TestCase
{
    public function test_it_can_parse_the_route_attribute()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerClass(RouteController::class);
        $generator->writeDocs();

        $this->assertPageGenerated('route');
        $this->assertEquals('route', $generator->endpoints->first()->route->description);
        $this->assertEquals('get', $generator->endpoints->first()->route->method);
        $this->assertEquals('/route', $generator->endpoints->first()->route->uri);
    }
}
