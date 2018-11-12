<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class Language
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
//        find first segment from url
        if (!empty(Request::segment(1))){
            $lang_code = Request::segment(1);
        }else{
            $lang_code = 'ar';
        }
        if (in_array($lang_code,config('app.locals'))){
            session()->put('lang',$lang_code);
            App::setLocale($lang_code);
        }else{
            session()->put('lang',App::getLocale());
            App::setLocale(App::getLocale());
        }
        return $next($request);
    }
}
