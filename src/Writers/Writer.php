<?php

namespace Wingly\ApiDoc\Writers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

abstract class Writer
{
    protected Filesystem $files;

    protected string $directory;

    abstract public function generate();

    public function __construct(protected Collection $endpoints)
    {
        $this->files = app()->make(Filesystem::class);

        $this->directory = storage_path('apidocs/');
    }
}
