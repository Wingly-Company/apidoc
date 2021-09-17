<?php

namespace Wingly\ApiDoc\Tests\Attributes;

use Wingly\ApiDoc\DocumentationGenerator;
use Wingly\ApiDoc\Tests\Stubs\BodyParameterController;
use Wingly\ApiDoc\Tests\TestCase;

class BodyParameterTest extends TestCase
{
    public function test_it_can_parse_the_body_parameter_attribute()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerClass(BodyParameterController::class);
        $generator->writeDocs();

        $endpoint = $generator->endpoints
            ->where('route.description', 'unique parameter')->first();

        $this->assertPageGenerated('unique-parameter');
        $this->assertCount(1, $endpoint->bodyParameters);
    }

    public function test_it_can_parse_multiple_body_parameters()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerClass(BodyParameterController::class);
        $generator->writeDocs();

        $endpoint = $generator->endpoints
            ->where('route.description', 'many parameters')->first();

        $this->assertPageGenerated('many-parameters');
        $this->assertCount(2, $endpoint->bodyParameters);
    }
}
