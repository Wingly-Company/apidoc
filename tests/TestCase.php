<?php

namespace Wingly\ApiDoc\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Wingly\ApiDoc\ApiDocServiceProvider;
use Wingly\ApiDoc\DocumentationGenerator;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $generator = (new DocumentationGenerator())
            ->useBasePath($this->getTestPath())
            ->useRootNamespace('Wingly\ApiDoc\Tests\\');

        $this->app->instance(DocumentationGenerator::class, $generator);
    }

    public function getTestPath(string $directory = null): string
    {
        return __DIR__ . ($directory ? '/' . $directory : '');
    }

    protected function getPackageProviders($app)
    {
        return [ApiDocServiceProvider::class];
    }
}
