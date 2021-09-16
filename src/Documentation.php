<?php

namespace Wingly\ApiDoc;

use Illuminate\Filesystem\Filesystem;
use Michelf\MarkdownExtra;

class Documentation
{
    protected $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function getTitle()
    {
        return config('apidoc.title');
    }

    public function getIndex()
    {
        $path = storage_path('apidocs/documentation.md');

        if ($this->files->exists($path)) {
            return MarkdownExtra::defaultTransform($this->files->get($path));
        }

        return null;
    }

    public function get($page)
    {
        $path = storage_path('apidocs/' . $page . '.md');

        if ($this->files->exists($path)) {
            return MarkdownExtra::defaultTransform($this->files->get($path));
        }

        return null;
    }
}
