<?php

namespace Wingly\ApiDoc\Tests\Attributes;

use Wingly\ApiDoc\DocumentationGenerator;
use Wingly\ApiDoc\Tests\Stubs\GroupController;
use Wingly\ApiDoc\Tests\Stubs\NoGroupController;
use Wingly\ApiDoc\Tests\TestCase;

class GroupTest extends TestCase
{
    public function test_it_can_parse_the_group_attribute()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerClass(GroupController::class);
        $generator->writeDocs();

        $this
            ->assertPageGenerated('grouped')
            ->assertEquals('Grouped', $generator->endpoints->first()->group);
    }

    public function test_endpoints_without_group_default_to_general_group()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerClass(NoGroupController::class);
        $generator->writeDocs();

        $this
            ->assertPageGenerated('not-grouped')
            ->assertEquals('General', $generator->endpoints->first()->group);
    }
}
