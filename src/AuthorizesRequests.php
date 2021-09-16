<?php

namespace Wingly\ApiDoc;

use Closure;
use Illuminate\Http\Request;

class AuthorizesRequests
{
    public static Closure $authUsing;

    public static function auth(callable $callback): static
    {
        static::$authUsing = $callback;

        return new static();
    }

    public static function check(Request $request): bool
    {
        return (static::$authUsing ?: function () {
            return app()->environment('local');
        })($request);
    }
}
