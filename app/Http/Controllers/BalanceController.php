<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use Auth;
use App\Policies\BalancePolicy;
class BalanceController extends Controller
{
	public function index(){

	}

	public function create(){
        return view('balances.create');
	}

    public function store(request $request){

    	$balance = new Balance;

    	$this->authorize('create', $balance);

    	$balance->user_id = Auth::user()->id;

    	$balance->save();

        session()->flash('success', 'Your currencyes has been created.');

        if(session()->has('URL')){
            return redirect(session()->get('URL'));
        }else{
            return redirect('home');
        }
    }



}
