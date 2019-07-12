<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Withdraw;
use App\Balance;
use App\Http\Requests\withdrawRequest;
use App\Traits\order_queue;

class WithdrawController extends Controller
{

	use order_queue;

    // Accept withdraw
    public function accept(Request $request){
    	$id = $request->input('id');
        $withdraw = Withdraw::find($id);
        $balance = Balance::where('user_id', $withdraw->user_id)->first();

        $this->Authorize('accept', $withdraw);

		$hold_payment_method = 'hold_'.strtolower($withdraw->p_method.'_'.$withdraw->currency);

		$balance->$hold_payment_method = $balance->$hold_payment_method - $request->input('amount');
		$balance->save();

        $withdraw->the_status = "accepted";
        $withdraw->amount = $request->input('amount');
        $withdraw->save();

        $this->order_withdraw();

        return redirect(url('admin/withdraws'))->with(['message' => "Withdraw Accepted", 'alert-type' => 'success']);
    }


    // Refuse withdraw
    public function refuse(Request $request){
    	$id = $request->input('id');
        $withdraw = Withdraw::find($id);
		$balance = Balance::where('user_id', $withdraw->user_id)->first();

		$this->Authorize('refuse', $withdraw);

		$payment_method = strtolower($withdraw->p_method.'_'.$withdraw->currency);
		$balance->$payment_method = $balance->$payment_method + $withdraw->amount;

		$hold_payment_method = 'hold_'.$payment_method;
		$balance->$hold_payment_method = $balance->$hold_payment_method - $withdraw->amount;
		$balance->save();

        $withdraw->the_status = "refused";
        $withdraw->save();

        $this->order_withdraw();

        return redirect(url('admin/withdraws'))->with(['message' => "Withdraw Refused", 'alert-type' => 'success']);
    }

}
