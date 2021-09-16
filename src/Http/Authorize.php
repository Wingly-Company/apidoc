<?php

namespace Wingly\ApiDoc\Http;

use Wingly\ApiDoc\AuthorizesRequests;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return AuthorizesRequests::check($request) ? $next($request) : abort(403);
    }
}
