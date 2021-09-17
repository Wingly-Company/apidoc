<?php

namespace Wingly\ApiDoc;

use Closure;

class AuthorizesRequests
{
    public static Closure $authUsing;

    public static function auth(callable $callback)
    {
        static::$authUsing = $callback;

        return new static();
    }

    public static function check($request)
    {
        return (static::$authUsing ?: function () {
            return app()->environment('local');
        })($request);
    }
}
