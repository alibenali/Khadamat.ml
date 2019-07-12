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





// Index website
Route::get('/', function () {
    return view('welcome');
});

Route::resource('service', 'ServicesController');
Route::get('services/{cat?}/{subcut?}', 'ServicesController@index');

Route::resource('deposit', 'DepositController');
Route::get('deposit/cancel/{id}', 'DepositController@cancel');
Route::get('deposit/urgent_verification/{id}', 'DepositController@urgent_verification');



Route::resource('balance', 'BalanceController');
Route::resource('payment', 'PaymentController');
Route::get('payment/confirm/{id}', 'PaymentController@confirm');

Route::resource('conversation', 'ConversationController');


Route::resource('message', 'MessageController');
Route::post('message/ajax', 'MessageController@ajax_store')->name('message.ajax');


Route::resource('profile', 'ProfileController');

Route::resource('withdraw', 'WithdrawController');
Route::get('withdraw/cancel/{id}', 'WithdrawController@cancel');

Route::resource('offer', 'OfferController');
Route::post('offer/accept', 'OfferController@accept');


Route::post('deposit/fetch', 'DepositController@fetch')->name('deposit.fetch');
Route::post('conversation/fetch', 'ConversationController@fetch')->name('conversation.fetch');


Auth::routes();


// Home after Login
Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix' => 'manage'], function () {
    Voyager::routes();
    Route::resource('conversation', '\App\Http\Controllers\Voyager\ConversationController')->middleware('admin.user');
    //Route::resource('payment', '\App\Http\Controllers\Voyager\PaymentController')->middleware('admin.user');
    Route::post('deposit/accept', 'Voyager\DepositController@accept');
    Route::post('deposit/refuse', 'Voyager\DepositController@refuse');
    Route::post('withdraw/accept', 'Voyager\WithdrawController@accept');
    Route::post('withdraw/refuse', 'Voyager\WithdrawController@refuse');
    Route::post('payment/accept', 'Voyager\PaymentController@accept');
    Route::post('payment/refuse', 'Voyager\PaymentController@refuse');

});
