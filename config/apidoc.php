<?php

return [
    'title' => env('APP_NAME'),

    'description' => '',

    'base_url' => env('APP_URL'),

    'route_prefix' => '/docs',

    'directories' => [
        app_path('Http/Controllers'),
    ],

    'intro_text' => <<<INTRO
This documentation aims to provide all the information you need to work with our API.
INTRO
];
