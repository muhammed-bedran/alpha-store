<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class SetLocaleFromSession
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       $locale = session('locale',config('app.locale'));
       if(LaravelLocalization::checkLocaleInSupportedLocales($locale)){
        app()->setLocale($locale);
       }
        return $next($request);
    }
}
