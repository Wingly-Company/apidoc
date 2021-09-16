<?php

namespace Wingly\ApiDoc\Commands;

use Illuminate\Console\Command;
use Wingly\ApiDoc\DocumentationGenerator;

class GenerateDocumentationCommand extends Command
{
    public $signature = 'apidoc:generate';

    public $description = 'Generate API documentation';

    public function handle(DocumentationGenerator $generator): int
    {
        collect($this->getRouteDirectories())
            ->each(
                fn (string $directory) => $generator->registerDirectory($directory)
            );

        $generator->writeDocs();

        return 0;
    }

    private function getRouteDirectories(): array
    {
        $testClassDirectory = __DIR__ . '/../../tests/Stubs';

        return app()->runningUnitTests() && file_exists($testClassDirectory)
            ? (array) $testClassDirectory
            : config('apidoc.directories');
    }
}
