<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Withdraw;
use App\Balance;
use App\BalanceHistory;
use App\Http\Requests\withdrawRequest;
use Auth;
use App\Traits\balance_to_hold;
use App\PaymentMethod;
use App\Currency;
use App\Traits\order_queue;
use App\Traits\createNotification;


class WithdrawController extends Controller
{
    



    // use the trait tp convert balance to hold
	use balance_to_hold;
    use order_queue;
    use createNotification;

    // List of Withdraws
    public function index(){

        $list_withdraw = Withdraw::where('user_id', Auth::id())->orderBy('id', 'desc')->get();


        return view('withdraws.index', ['withdraws' => $list_withdraw]);
    }






    // Show a withdraw
    public function show($id){
        $withdraw = Withdraw::find($id);

        $this->authorize('view', $withdraw);

        return view('withdraws.withdraw_details', ['withdraw' => $withdraw]);
    }









    // Create withdraw
    public function create(){
        $payment_methods = PaymentMethod::all();
        $currencies = Currency::all();

        return view('withdraws.create', ['payment_methods' => $payment_methods, 'currencies' => $currencies]);
    }








    // Save withdraw
    public function store(withdrawRequest $Request){

        $withdraw = new withdraw;
        $withdraw->user_id       = Auth::user()->id;
        $withdraw->p_method      = $Request->input('p_method');
        $withdraw->currency      = $Request->input('currency');
        $withdraw->p_info        = $Request->input('p_info');
        $withdraw->amount        = $Request->input('amount');

        $queue = withdraw::where('the_status', 'open')->count();
        $withdraw->the_queue     = $queue+1;
        $withdraw->save();

        $p_method = strtolower($Request->input('p_method').'_'.$Request->input('currency'));
        $hold_p_method = 'hold_'.$p_method;
        $balance = Balance::where('user_id', Auth::user()->id)->get()->first();
        
        $old_balance = $balance->$p_method;
        $old_hold_balance = $balance->$hold_p_method;

        $balance_amount = $Request->input('amount');

        $new_balance = $old_balance - $balance_amount;
        $new_hold_balance = $old_hold_balance + $balance_amount;

        $balance->$p_method = $new_balance;
        $balance->$hold_p_method = $new_hold_balance;
        $balance->save();


        //Add BalanceHistory
        $bal_histo = new BalanceHistory;
        $bal_histo->user_id = $withdraw->user_id;
        $bal_histo->causer_id = Auth::id();
        $bal_histo->purpose = "Withdraw opened";
        $bal_histo->p_method = $p_method;
        $bal_histo->old = $old_balance;
        $bal_histo->amount = $balance_amount;
        $bal_histo->new = $new_balance;
        $bal_histo->url = "withdraw/".$withdraw->id;
        $bal_histo->save();

        $bal_histo_hold = new BalanceHistory;
        $bal_histo_hold->user_id = $withdraw->user_id;
        $bal_histo_hold->causer_id = Auth::id();
        $bal_histo_hold->purpose = "Withdraw opened";
        $bal_histo_hold->p_method = $hold_p_method;
        $bal_histo_hold->old = $old_hold_balance;
        $bal_histo_hold->amount = $balance_amount;
        $bal_histo_hold->new = $new_hold_balance;
        $bal_histo_hold->url = "withdraw/".$withdraw->id;
        $bal_histo_hold->save();

        $this->order_withdraw();
        
        $this->createNotification(Auth::id(),'withdrawRequestSent','',url('withdraw'.$withdraw->id));

        return redirect('withdraw');
    }








    // edit withdraw
    public function edit(){

    }









    // Cancel withdraw
    public function cancel($id){
        $withdraw = Withdraw::find($id);
        $balance = Balance::where('user_id', $withdraw->user_id)->first();

        $this->Authorize('cancel', $withdraw);


        $payment_method = strtolower($withdraw->p_method.'_'.$withdraw->currency);
        $balance->$payment_method = $balance->$payment_method + $withdraw->amount;

        $hold_payment_method = 'hold_'.$payment_method;
        $balance->$hold_payment_method = $balance->$hold_payment_method - $withdraw->amount;
        $balance->save();
        
        $withdraw->the_status = "cancelled";
        $withdraw->save();

        $this->order_withdraw();

        return redirect('withdraw/'.$id.'');
    }


    // Accept withdraw
    public function accept(Request $request){
    	$id = $request->input('id');
        $withdraw = Withdraw::find($id);
        $balance = Balance::where('user_id', $withdraw->user_id)->first();

        $this->Authorize('accept', $withdraw);

		$hold_payment_method = 'hold_'.strtolower($withdraw->p_method);

		$balance->$hold_payment_method = $balance->$hold_payment_method - $request->input('amount');
		$balance->save();

        $withdraw->the_status = "accepted";
        $withdraw->amount = $request->input('amount');
        $withdraw->save();

        $this->order_withdraw();

        return redirect('withdraw/'.$id.'');
    }


    // Refuse withdraw
    public function refuse(Request $request){
    	$id = $request->input('id');
        $withdraw = Withdraw::find($id);
		$balance = Balance::where('user_id', $withdraw->user_id)->first();

		$this->Authorize('refuse', $withdraw);

		$payment_method = strtolower($withdraw->p_method);
		$balance->$payment_method = $balance->$payment_method + $withdraw->amount;

		$hold_payment_method = 'hold_'.strtolower($withdraw->p_method);
		$balance->$hold_payment_method = $balance->$hold_payment_method - $withdraw->amount;
		$balance->save();

        $withdraw->the_status = "refused";
        $withdraw->save();

        $this->order_withdraw();

        return redirect('withdraw/'.$id.'');
    }

    // Delete withdraw
    public function destroy(){

    }

}
