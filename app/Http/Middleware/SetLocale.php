<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

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
        Log::info('SetLocale middleware ejecutado');
        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
            Log::info('SetLocale middleware: ' . $locale);
            App::setLocale($locale);
        }

        return $next($request);
    }
}
