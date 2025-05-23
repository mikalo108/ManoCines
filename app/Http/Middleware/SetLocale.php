<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       $locale = $request->session()->get('locale') ?? $request->cookie('locale');
        if ($locale) {
            App::setLocale($locale);
            Lang::setLocale($locale);
        }

        return $next($request);
    }
}
