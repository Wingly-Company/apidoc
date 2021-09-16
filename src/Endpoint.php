<?php

namespace Wingly\ApiDoc;

use Illuminate\Support\Str;
use Wingly\ApiDoc\Attributes\Route;
use Wingly\ApiDoc\Attributes\UrlParameter;

class Endpoint
{
    public string $group = 'General';

    public Route $route;

    public bool $authenticated = false;

    public array $urlParameters = [];

    public array $bodyParameters = [];

    public array $responses = [];

    public function getFilePath()
    {
        return Str::snake($this->route->description, '-');
    }

    public function addParameter($parameter)
    {
        if ($parameter instanceof UrlParameter) {
            $this->urlParameters[] = $parameter;
        } else {
            $this->bodyParameters[] = $parameter;
        }
    }

    public function addResponse($response)
    {
        $this->responses[] = $response;
    }
}
