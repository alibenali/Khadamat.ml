<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use Auth;
use App\Policies\BalancePolicy;
use App\Traits\createNotification;

class BalanceController extends Controller
{
    use createNotification;

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

        $this->createNotification(Auth::id(),'currenciesCreated','','');

        if(session()->has('URL')){
            return redirect(session()->get('URL'));
        }else{
            return redirect('home');
        }
    }



}
