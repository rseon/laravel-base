<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */
    public function handle($request, Closure $next, string $role)
    {
        if(!$request->user()->hasRole($role)) {
            return redirect()->route('manager')->withErrors(__('auth.not_authorized'));
        }
        return $next($request);
    }
}
