<?php

namespace App\Traits;
use App\Balance;

trait balance_to_hold {

	public function balance_to_hold($user_id, $p_method, $new_balance)
	{

    	$balance = Balance::where('user_id', '=', $user_id)->firstOrFail();

    	$hold = 'hold_'.$p_method;
    	$balance->$hold = $balance->$hold + $balance->$p_method - $new_balance;

    	$balance->$p_method = $new_balance;

    	$balance->save();
    	
    }

}