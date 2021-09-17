<?php

namespace Wingly\ApiDoc\Writers;

use Illuminate\Support\Facades\View;

class MarkdownWriter extends Writer
{
    public function generate()
    {
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

        $this->files->put($this->directory . 'documentation.md', $output);
    }

    public function generateIntroduction()
    {
        $output = View::make('apidoc::introduction', [
            'description' => config('apidoc.description'),
            'baseUrl' => config('apidoc.base_url'),
            'introText' => config('apidoc.intro_text')
        ])->render();

        $this->files->put($this->directory . 'introduction.md', $output);
    }

    public function generateEndpoints()
    {
        $this->endpoints->each(function ($endpoint) {
            $output = View::make('apidoc::endpoint', [
                'endpoint' => $endpoint,
            ])->render();

            $filename = $endpoint->getFilePath() . '.md';

            $this->files->put($this->directory . $filename, $output);
        });
    }
}
