<?php

namespace Wingly\ApiDoc\Tests;

use Illuminate\Support\Facades\File;
use Wingly\ApiDoc\DocumentationGenerator;

class GenerateDocumentationTest extends TestCase
{
    public function test_it_creates_the_apidoc_directory()
    {
        $this->artisan('apidoc:generate')
            ->assertExitCode(0);

        $this->assertTrue(File::exists($this->storagePath()));
    }

    public function test_it_generates_an_introduction_page()
    {
        $this->artisan('apidoc:generate');

        $this->assertPageGenerated('introduction');
    }

    public function test_it_generates_the_documentation_index()
    {
        $this->artisan('apidoc:generate');

        $this->assertPageGenerated('documentation');
    }

    public function test_it_can_generate_docs_for_a_directory()
    {
        $generator = app(DocumentationGenerator::class);
        $generator->registerDirectory($this->getTestPath('Stubs/TestDirectory'));
        $generator->writeDocs();

        $this
            ->assertPageGenerated('the-first-index')
            ->assertPageGenerated('the-second-index');
    }
}
