<?php

use Illuminate\Support\Facades\Route;
use Wingly\ApiDoc\Http\DocsController;

$prefix = config('apidoc.route_prefix');

Route::redirect($prefix, $prefix . '/introduction');
Route::get($prefix . '/{page}', DocsController::class);
