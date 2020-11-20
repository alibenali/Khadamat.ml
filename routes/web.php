<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('lang/{lang}', function($lang){

    if(in_array($lang, ['ar', 'en',  'fr'])){

        if(auth()->user()){
            $user = auth()->user();
            $user->lang = $lang;
            $user->save();
        }else{
            if(session()->has('lang')){
                session()->forget('lang');
            }
            session()->put('lang', $lang);
        }

        session()->put('lang', $lang);
    }else{
        if(auth()->user()){
            $user = auth()->user();
            $user->lang = 'en';
            $user->save();
        }else{
            if(session()->has('lang')){
                session()->forget('lang');
            }
        
        session()->put('lang', 'en');
        }
    }
    return back();
})->name('lang');

Route::group(['middleware' => 'lang'], function(){


        
// Index website

Route::get('/', function () {
    $list_services = App\Service::where('the_status', 'open')->take(6)->get();
    return view('welcome', ['services' => $list_services]);
});



Route::resource('service', 'ServicesController');
Route::post('service/fetch', 'ServicesController@fetch')->name('service.fetch')->middleware('auth');
Route::get('services/{cat?}/{subcut?}', 'ServicesController@index');
Route::get('service/search/{search?}', 'ServicesController@search')->name('service.search')->middleware('auth');

Route::resource('deposit', 'DepositController')->middleware('auth')->middleware('CheckCurrencies');
Route::get('deposit/cancel/{id}', 'DepositController@cancel')->middleware('auth')->middleware('CheckCurrencies');
Route::get('deposit/urgent_verification/{id}', 'DepositController@urgent_verification')->middleware('auth')->middleware('CheckCurrencies');



Route::resource('balance', 'BalanceController')->middleware('auth')->middleware('verified');
Route::resource('payment', 'PaymentController')->middleware('auth')->middleware('CheckCurrencies');
Route::get('payment/confirm/{id}', 'PaymentController@confirm')->middleware('auth');
Route::post('payment/cancel', 'PaymentController@cancel')->middleware('CheckCurrencies');

Route::resource('conversation', 'ConversationController')->middleware('auth');


Route::resource('message', 'MessageController')->middleware('auth');
Route::post('message/ajax', 'MessageController@ajax_store')->name('message.ajax')->middleware('auth');


Route::resource('profile', 'ProfileController');
Route::post('profile/update_avatar', 'ProfileController@update_pic');

Route::resource('withdraw', 'WithdrawController')->middleware('auth')->middleware('CheckCurrencies');
Route::get('withdraw/cancel/{id}', 'WithdrawController@cancel')->middleware('auth')->middleware('CheckCurrencies');

Route::resource('offer', 'OfferController')->middleware('auth')->middleware('CheckCurrencies');
Route::post('offer/accept', 'OfferController@accept')->middleware('auth')->middleware('CheckCurrencies');


Route::post('deposit/fetch', 'DepositController@fetch')->name('deposit.fetch')->middleware('auth');
Route::post('conversation/fetch', 'ConversationController@fetch')->name('conversation.fetch')->middleware('auth');


Route::resource('notification', 'NotificationController')->middleware('auth');
Route::post('notification/seen', 'NotificationController@seen')->middleware('auth');

Route::resource('cart', 'CartController')->middleware('auth');
Route::post('cart/delete', 'CartController@delete')->middleware('auth');

Route::post('rating/rateService', 'RatingController@rateService')->middleware('auth');

Route::post('search/fetch', 'SearchController@fetch')->name('search.fetch')->middleware('auth');

Route::get('balance-history', 'balanceHistoryController@index')->name('balanceHistory');


Auth::routes(['verify' => true]);


// Home after Login
Route::get('/home', 'HomeController@show')->name('home')->middleware('auth');


Route::group(['prefix' => 'server', 'middleware' => ['auth','server']], function(){

    Route::get('/', 'Server\PaymentController@index');
    Route::resource('service', 'Server\ServiceController')->middleware('auth');
    Route::resource('payment', 'Server\PaymentController')->middleware('auth');
    Route::get('earning', 'Server\PaymentController@indexEarning')->middleware('auth');
    Route::resource('conversation', 'Server\ConversationController')->middleware('auth');
    Route::post('conversation/fetch', 'Server\ConversationController@fetch')->name('server.conversation.fetch')->middleware('auth');

});

});






Route::group(['prefix' => 'manage'], function () {
    Voyager::routes();
    Route::resource('conversation', '\App\Http\Controllers\Voyager\ConversationController')->middleware('admin.user');
    Route::post('conversation/fetch', 'Voyager\ConversationController@fetch')->name('manage.conversation.fetch')->middleware('auth');

    //Route::resource('payment', '\App\Http\Controllers\Voyager\PaymentController')->middleware('admin.user');
    Route::post('deposit/accept', 'Voyager\DepositController@accept');
    Route::post('deposit/refuse', 'Voyager\DepositController@refuse');
    Route::post('withdraw/pending', 'Voyager\WithdrawController@pending');
    Route::post('withdraw/accept', 'Voyager\WithdrawController@accept');
    Route::post('withdraw/refuse', 'Voyager\WithdrawController@refuse');
    Route::post('payment/pending', 'Voyager\PaymentController@pending');
    Route::post('payment/accept', 'Voyager\PaymentController@accept');
    Route::post('payment/pay', 'Voyager\PaymentController@pay');
    Route::post('payment/refuse', 'Voyager\PaymentController@refuse');
    Route::post('payment/refund', 'Voyager\PaymentController@refund');

});
