<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Withdraw;
use App\Balance;
use App\Http\Requests\withdrawRequest;
use App\Traits\order_queue;
use App\Traits\createNotification;
use App\Traits\balanceTrait;

class WithdrawController extends Controller
{

	use order_queue;
    use createNotification;
    use balanceTrait;

    // Accept withdraw
    public function accept(Request $request){
    	$id = $request->input('id');
        $withdraw = Withdraw::find($id);
        $balance = Balance::where('user_id', $withdraw->user_id)->first();

        $this->Authorize('accept', $withdraw);

		$hold_payment_method = 'hold_'.strtolower($withdraw->p_method.'_'.$withdraw->currency);

        $old_hold_balance = $balance->$hold_payment_method;
        $balance_amount = $request->input('amount');


        $withdraw->the_status = "accepted";
        $withdraw->amount = $request->input('amount');
        $withdraw->save();

        $this->order_withdraw();
        $this->createNotification($withdraw->user_id,'withdrawAccepted','',url('withdraw/'.$withdraw->id));
        $this->balanceDown($withdraw->user_id, $hold_payment_method, $balance_amount, "Withdraw accpeted", "withdraw/".$withdraw->id);

        return redirect(url('manage/withdraws'))->with(['message' => "Withdraw Accepted", 'alert-type' => 'success']);
    }


    // Accept withdraw
    public function pending(Request $request){
        $id = $request->input('id');
        $withdraw = Withdraw::find($id);

        $this->Authorize('pending', $withdraw);

        $withdraw->the_status = "pending";
        $withdraw->amount = $request->input('amount');
        $withdraw->save();

        $this->order_withdraw();
        $this->createNotification($withdraw->user_id,'withdrawPending','',url('withdraw/'.$withdraw->id));

        return redirect(url('manage/withdraws'))->with(['message' => "Withdraw Accepted", 'alert-type' => 'success']);
    }

    // Refuse withdraw
    public function refuse(Request $request){
    	$id = $request->input('id');
        $withdraw = Withdraw::find($id);
		$balance = Balance::where('user_id', $withdraw->user_id)->first();

		$this->Authorize('refuse', $withdraw);

        $withdraw->the_status = "refused";
        $withdraw->save();

		$payment_method = strtolower($withdraw->p_method.'_'.$withdraw->currency);
        $hold_payment_method = 'hold_'.$payment_method;

        $this->balanceUp($withdraw->user_id, $payment_method, $withdraw->amount, "Withdraw refused", "withdraw/".$withdraw->id);

        $this->balanceDown($withdraw->user_id, $hold_payment_method, $withdraw->amount, "Withdraw refused", "withdraw/".$withdraw->id);

        $this->order_withdraw();
        $this->createNotification($withdraw->user_id,'withdrawRefused','',url('withdraw/'.$withdraw->id));

        return redirect(url('manage/withdraws'))->with(['message' => "Withdraw Refused", 'alert-type' => 'success']);
    }

}
