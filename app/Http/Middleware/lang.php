<?php

namespace App\Http\Middleware;

use Closure;

class lang
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
        app()->setlocale(app('lang'));

        // RTL things
        if(app('lang') == 'ar'){
            $rtl = 'dir=rtl';
            $tdir = 'text-right';
            $dir = 'right';
        }else{
            $rtl = '';
            $tdir = '';
            $dir = 'left';
        }
        \View::share('rtl', $rtl);
        \View::share('tdir', $tdir);
        \View::share('dir', $dir);


        return $next($request);
    }
}
