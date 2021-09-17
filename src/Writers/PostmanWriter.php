<?php

namespace Wingly\ApiDoc\Writers;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class PostmanWriter extends Writer
{
    /**
     * Postman collection schema version
     * https://schema.getpostman.com/json/collection/v2.1.0/collection.json
     */
    const VERSION = '2.1.0';

    public function generate()
    {
        $collection = $this->buildCollection();

        $this->files->put($this->directory . 'postman.json', json_encode($collection, JSON_PRETTY_PRINT));
    }

    protected function buildCollection()
    {
        return [
            'variable' => [
                [
                    'id' => 'base_url',
                    'key' => 'base_url',
                    'type' => 'string',
                    'name' => 'base_url',
                    'value' => parse_url(config('apidoc.base_url'), PHP_URL_HOST) ?: config('apidoc.base_url'),
                ],
            ],
            'info' => [
                'name' => config('apidoc.title'),
                'description' => config('apidoc.description'),
                '_postman_id' => Uuid::uuid4()->toString(),
                'schema' => 'https://schema.getpostman.com/json/collection/v' . self::VERSION . '/collection.json',
            ],
            'item' => $this->groups(),
        ];
    }

    protected function groups()
    {
        return $this->endpoints
            ->groupBy(function ($endpoint) {
                return $endpoint->group;
            })->map(function ($endpoints, $group) {
                return [
                    'name' => $group,
                    'item' => $endpoints
                        ->map(fn ($endpoint) => $this->endpointItem($endpoint))
                        ->toArray(),
                ];
            })->values()->toArray();
    }

    protected function endpointItem($endpoint)
    {
        return [
            'name' => $endpoint->route->uri,
            'request' => [
                'url' => $this->generateUrlObject($endpoint),
                'description' => $endpoint->route->description,
                'method' => Str::upper($endpoint->route->method),
            ],
        ];
    }

    protected function generateUrlObject($endpoint)
    {
        return [
            'protocol' => Str::startsWith(config('apidoc.base_url'), 'https') ? 'https' : 'http',
            'host' => '{{base_url}}',
            'path' => preg_replace_callback('/\{(\w+)\??}/', function ($matches) {
                return ':' . $matches[1];
            }, $endpoint->route->uri),
        ];
    }
}
