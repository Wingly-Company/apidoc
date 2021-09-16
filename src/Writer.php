<?php

namespace Wingly\ApiDoc;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class Writer
{
    protected Collection $endpoints;

    protected Filesystem $files;

    public function __construct()
    {
        $this->endpoints = Collection::make();

        $this->files = app()->make(Filesystem::class);
    }

    public function addEndpoint(Endpoint $endpoint)
    {
        $this->endpoints->push($endpoint);
    }

    public function endpoints()
    {
        return $this->endpoints;
    }

    public function generate()
    {
        $this->prune();

        $this->generateIndex();

        $this->generateIntroduction();

        $this->generateEndpoints();
    }

    public function generateIndex()
    {
        $groupedEndpoints = $this->endpoints
            ->groupBy(function ($endpoint) {
                return $endpoint->group;
            });

        $output = View::make('apidoc::documentation', [
            'groupedEndpoints' => $groupedEndpoints,
        ])->render();

        $this->files->put($this->getDirectory() . 'documentation.md', $output);
    }

    public function generateIntroduction()
    {
        $output = View::make('apidoc::introduction', [
            'description' => config('apidoc.description'),
            'baseUrl' => config('apidoc.base_url'),
            'introText' => config('apidoc.intro_text')
        ])->render();

        $this->files->put($this->getDirectory() . 'introduction.md', $output);
    }

    public function generateEndpoints()
    {
        $this->endpoints->each(function ($endpoint) {
            $output = View::make('apidoc::endpoint', [
                'endpoint' => $endpoint,
            ])->render();

            $filename = $endpoint->getFilePath() . '.md';

            $this->files->put($this->getDirectory() . $filename, $output);
        });
    }

    protected function prune()
    {
        $this->files->deleteDirectory($this->getDirectory());

        $this->files->makeDirectory($this->getDirectory(), 0777, true);

        $this->files->put($this->getDirectory() . '.gitignore', "*\n!.gitignore\n");
    }

    protected function getDirectory()
    {
        return storage_path('apidocs/');
    }
}
