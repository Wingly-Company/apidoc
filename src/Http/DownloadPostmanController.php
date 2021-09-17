<?php

namespace Wingly\ApiDoc\Http;

class DownloadPostmanController
{
    public function __invoke()
    {
        return response()
            ->download(storage_path('apidocs/postman.json'));
    }
}
