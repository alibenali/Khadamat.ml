<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Deposit;
use Illuminate\Support\Facades\Schema;
use App\Notification;
use App\Cart;
use App\User;
use App\Providers\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        app()->singleton('lang', function(){
            if(auth()->user()){

                if(empty(auth()->user()->lang)){
                    return 'en';
                }else{
                    return auth()->user()->lang;
                }
            }else{
                if(session()->has('lang')){
                    return session()->get('lang');
                }else{
                    return 'en';
                }
            }
        });

        //compose all the views....
            view()->composer('*', function ($view) 
            {
                if(auth()->user()){
                $notifications = Notification::where('to_user', '=' ,auth()->user()->id)->orderBy('id', 'desc')->take(4)->get();
                $not_seen_notification = Notification::where('to_user', '=' ,auth()->user()->id)->where('seen', '0')->count();

                $carts = Cart::where('user_id', '=' ,auth()->user()->id)->where('the_status', 'not_seen')->count();

                $user = User::find(auth()->user()->id)->firstOrFail();

                //...with this variable
                $view->with('notifications', $notifications )
                     ->with('not_seen_notification', $not_seen_notification )
                     ->with('num_carts', $carts )
                     ->with('user', auth()->user());
                }
            });
  
            view()->composer('server.*', function ($view) {
                $view->with('server', '1');
            });

        Schema::defaultStringLength(191);

        if(env('APP_DEBUG')) {
            DB::listen(function($query) {
                File::append(
                    storage_path('/logs/query.log'),
                    $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL
               );
            });
        }
    }
}
