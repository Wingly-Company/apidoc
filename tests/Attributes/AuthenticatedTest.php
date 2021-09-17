<?php

namespace Wingly\ApiDoc\Tests\Attributes;

use Wingly\ApiDoc\DocumentationGenerator;
use Wingly\ApiDoc\Tests\Stubs\AuthenticatedController;
use Wingly\ApiDoc\Tests\TestCase;

class AuthenticatedTest extends TestCase
{
    public function test_it_can_parse_the_authenticated_attribute()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerClass(AuthenticatedController::class);
        $generator->writeDocs();

        $this
            ->assertPageGenerated('authenticated')
            ->assertTrue($generator->writer->endpoints()->first()->authenticated);
    }
}
