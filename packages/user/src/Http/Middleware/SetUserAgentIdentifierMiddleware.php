<?php

namespace User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetUserAgentIdentifierMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse|mixed
     *
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $identifier = \Cookie::get('userAgentIdentifier');

        app()->make('modules')->set('user.userAgentIdentifier', $identifier);

        return $next($request);
    }
}
