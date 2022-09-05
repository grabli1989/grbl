<?php

namespace User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use User\Models\User;

class UserIsConfirmedMiddleware
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
        /** @var User $user */
        $user = $request->user();
        if ($user->isConfirmed() && ! $user->tokenCan('onlyConfirmation')) {
            return $next($request);
        }

        return response()->json(['access' => 'Access denied'], 403);
    }
}
