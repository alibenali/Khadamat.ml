<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Balance;

class CheckCurrencies
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
        $currency = Balance::where('user_id', Auth::id())->count();

        if($currency == 1){
        return $next($request);
        }

        $request->session()->flash('danger', __('profile.noBalance'));


        return redirect('/home');
    }
}
