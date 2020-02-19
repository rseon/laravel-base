<?php

namespace App\Http\Middleware;

use Closure;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Do not handle during switch lang action
        if($request->route()->named('switch_locale')) {
            return $next($request);
        }

        if(session()->has('locale')) {
            $locale = session('locale');
        }
        else {
            $locale = config()->get('app.locale');
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);
        return $next($request);
    }
}
