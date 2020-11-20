<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Auth;

class CartController extends Controller
{
	
    public function index(){

    	$cart = Cart::where('user_id', Auth::id())->where('the_status', '!=', 'deleted')->get();
    	$update_carts = Cart::where('user_id', Auth::id())->where('the_status', '!=', 'deleted')->update(['the_status' => 'seen']);

    	return view('carts.index', ['carts' => $cart]);

    }

    public function delete(Request $request){

    	$cart = Cart::find($request->input('id'));

    	$this->authorize('delete', $cart);

    	$cart->the_status = 'deleted';
    	$cart->save();

    	return redirect(url()->previous());
    }
}
