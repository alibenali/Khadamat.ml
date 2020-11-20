<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Deposit;
use App\Balance;
use App\Http\Requests\depositRequest;
use Auth;
use App\Traits\order_queue;
use App\Traits\createNotification;
use App\Traits\balanceTrait;

class DepositController extends Controller
{
    use order_queue;
    use createNotification;
    use balanceTrait;

    // Accept deposit
    public function accept(Request $request){
    	$id = $request->input('id');
        $deposit = Deposit::find($id);
        $balance = Balance::where('user_id', $deposit->user_id)->first();

        $this->Authorize('accept', $deposit);

		$payment_method = strtolower($deposit->p_method.'_'.$deposit->currency);
        $balance_amount = $request->input('amount');

        $this->balanceUp($deposit->user_id, $payment_method, $balance_amount, "Deposit accpeted", "deposit/".$deposit->id);

        $deposit->the_status = "Accepted";
        $deposit->amount = $request->input('amount');

        $deposit->save();

        $this->order();
        $this->createNotification($deposit->user_id,'depositAccepted','',url('deposit/'.$deposit->id));

        return redirect(url('manage/deposits'))->with(['message' => "Deposit Accepted", 'alert-type' => 'success']);
    }


    // Refuse deposit
    public function refuse(Request $request){
    	$id = $request->input('id');
        $deposit = Deposit::find($id);

        $deposit->the_status = "Refused";
        $deposit->save();

        $this->order();
        
        session()->flash('success', 'The deposit has been refused.');
        
        $this->createNotification($deposit->user_id,'depositRefused','',url('deposit/'.$deposit->id));

        return redirect(url('manage/deposits'))->with(['message' => "Deposit Refused", 'alert-type' => 'success']);
    }

    // Delete Deposit
    public function destroy(){

    }
}
