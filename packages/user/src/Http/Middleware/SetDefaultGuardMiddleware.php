<?php

namespace User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetDefaultGuardMiddleware
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
        $modules = app()->make('modules');
        auth()->setDefaultDriver($modules->get('user.guard'));

        return $next($request);
    }
}
