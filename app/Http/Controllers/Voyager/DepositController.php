<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Deposit;
use App\Balance;
use App\Http\Requests\depositRequest;
use Auth;
use App\Traits\order_queue;

class DepositController extends Controller
{
    use order_queue;

    // Accept deposit
    public function accept(Request $request){
    	$id = $request->input('id');
        $deposit = Deposit::find($id);
        $balance = Balance::where('user_id', $deposit->user_id)->first();

        $this->Authorize('accept', $deposit);

		$payment_method = strtolower($deposit->p_method.'_'.$deposit->currency);

		$balance->$payment_method = $balance->$payment_method + $request->input('amount');
		$balance->save();

        $deposit->the_status = "Accepted";
        $deposit->amount = $request->input('amount');
        $deposit->save();

        $this->order();

        return redirect(url('admin/deposits'))->with(['message' => "Deposit Accepted", 'alert-type' => 'success']);
    }


    // Refuse deposit
    public function refuse(Request $request){
    	$id = $request->input('id');
        $deposit = Deposit::find($id);

        $deposit->the_status = "Refused";
        $deposit->save();

        $this->order();
        
        session()->flash('success', 'The deposit has been refused.');

        return redirect(url('admin/deposits'))->with(['message' => "Deposit Refused", 'alert-type' => 'success']);
    }

    // Delete Deposit
    public function destroy(){

    }
}
