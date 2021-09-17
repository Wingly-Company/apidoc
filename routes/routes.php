<?php

use Illuminate\Support\Facades\Route;
use Wingly\ApiDoc\Http\Authorize;
use Wingly\ApiDoc\Http\DocsController;
use Wingly\ApiDoc\Http\DownloadPostmanController;

$prefix = config('apidoc.route_prefix');

Route::redirect($prefix, $prefix . '/introduction');

Route::get($prefix . '/postman', DownloadPostmanController::class)
    ->middleware(Authorize::class);

Route::get($prefix . '/{page}', DocsController::class)
    ->middleware(Authorize::class);
