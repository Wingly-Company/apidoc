<?php

namespace Wingly\ApiDoc\Tests\Attributes;

use Wingly\ApiDoc\DocumentationGenerator;
use Wingly\ApiDoc\Tests\Stubs\UrlParameterController;
use Wingly\ApiDoc\Tests\TestCase;

class UrlParameterTest extends TestCase
{
    public function test_it_can_parse_the_url_parameter_attribute()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerClass(UrlParameterController::class);
        $generator->writeDocs();

        $endpoint = $generator->writer->endpoints()
            ->where('route.description', 'unique parameter')->first();

        $this->assertPageGenerated('unique-parameter');
        $this->assertCount(1, $endpoint->urlParameters);
    }

    public function test_it_can_parse_multiple_url_parameters()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerClass(UrlParameterController::class);
        $generator->writeDocs();

        $endpoint = $generator->writer->endpoints()
            ->where('route.description', 'many parameters')->first();

        $this->assertPageGenerated('many-parameters');
        $this->assertCount(2, $endpoint->urlParameters);
    }
}
