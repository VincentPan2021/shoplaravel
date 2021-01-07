<?php

namespace App\Http\Middleware;

use Closure;

class DetectLanguageMiddleware
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
        $language = $request->cookie('language');

        switch($language){
            case    'en':
                app()->setLocale('en');
                break;

            case    'zh-TW':
            default:
                app()->setLocale('zh-TW');
                break;
        }

        return $next($request);
    }
}
