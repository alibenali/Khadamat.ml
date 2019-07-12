<?php

namespace App\Traits;
use App\Deposit;
use App\Withdraw;

trait order_queue {

	public function order()
	{
    	

        $deposits = Deposit::where('the_status', 'open')->orderBy('the_queue')->get();
        $count = Deposit::where('the_status', 'open')->count();
        $number = 0;
        foreach($deposits as $deposit){
            $number++;
            $deposit->the_queue = $number;
            $deposit->save();
        }

        $deposits_off = Deposit::where('the_status', '!=', 'open')->update(array('the_queue' => 99999999999));



    }



    public function order_withdraw()
    {
        

        $withdraws = Withdraw::where('the_status', 'open')->orderBy('the_queue')->get();
        $count = Withdraw::where('the_status', 'open')->count();
        $number = 0;
        foreach($withdraws as $withdraw){
            $number++;
            $withdraw->the_queue = $number;
            $withdraw->save();
        }

        $withdraw_off = Withdraw::where('the_status', '!=', 'open')->update(array('the_queue' => 99999999999));



    }

}