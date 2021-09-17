<?php

namespace Wingly\ApiDoc\Tests\Attributes;

use Wingly\ApiDoc\DocumentationGenerator;
use Wingly\ApiDoc\Tests\Stubs\ResponseController;
use Wingly\ApiDoc\Tests\TestCase;

class ResponseTest extends TestCase
{
    public function test_it_can_parse_the_response_attribute()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerClass(ResponseController::class);
        $generator->writeDocs();

        $endpoint = $generator->writer->endpoints()
            ->where('route.description', 'unique response')->first();

        $this->assertPageGenerated('unique-response');
        $this->assertCount(1, $endpoint->responses);
    }

    public function test_it_can_parse_multiple_responses()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerClass(ResponseController::class);
        $generator->writeDocs();

        $endpoint = $generator->writer->endpoints()
            ->where('route.description', 'many responses')->first();

        $this->assertPageGenerated('many-responses');
        $this->assertCount(2, $endpoint->responses);
    }
}
