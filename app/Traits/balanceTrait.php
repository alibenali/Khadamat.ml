<?php

namespace App\Traits;
use App\Balance;
use App\BalanceHistory;
use Auth;

trait balanceTrait {

	public function balanceUp($user_id, $p_method, $amount, $purpose, $url)
	{

    	$balance = Balance::where('user_id', '=', $user_id)->firstOrFail();
    	$old_balance = $balance->$p_method;
        $new_balance = $old_balance + $amount;

		$balance->$p_method = $new_balance;

		//Add BalanceHistory
        $bal_histo = new BalanceHistory;
        $bal_histo->user_id = $user_id;
        $bal_histo->causer_id = Auth::id();
        $bal_histo->purpose = $purpose;
        $bal_histo->p_method = $p_method;
        $bal_histo->old = $old_balance;
        $bal_histo->amount = $amount;
        $bal_histo->new = $new_balance;
        $bal_histo->url = $url;
        $bal_histo->save();

    	$balance->save();
    	
    }

    public function balanceDown($user_id, $p_method, $amount, $purpose, $url)
    {

        $balance = Balance::where('user_id', '=', $user_id)->firstOrFail();
        $old_balance = $balance->$p_method;
        $new_balance = $old_balance - $amount;

        $balance->$p_method = $new_balance;

        //Add BalanceHistory
        $bal_histo = new BalanceHistory;
        $bal_histo->user_id = $user_id;
        $bal_histo->causer_id = Auth::id();
        $bal_histo->purpose = $purpose;
        $bal_histo->p_method = $p_method;
        $bal_histo->old = $old_balance;
        $bal_histo->amount = $amount;
        $bal_histo->new = $new_balance;
        $bal_histo->url = $url;
        $bal_histo->save();

        $balance->save();
        
    }

	public function enough($user_id, $p_method, $amount)
	{
    	$balance = Balance::where('user_id', '=', $user_id)->firstOrFail();

    	return $balance->$p_method >= $amount;
    }

}