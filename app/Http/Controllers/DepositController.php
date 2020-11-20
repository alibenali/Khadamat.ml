<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deposit;
use App\Balance;
use App\Http\Requests\depositRequest;
use Auth;
use App\PaymentMethod;
use App\Currency;
use App\Traits\order_queue;
use App\Traits\createNotification;

class DepositController extends Controller
{

    use createNotification;
    use order_queue;


    // List of deposits
    public function index(){

        $list_deposits = Deposit::where('user_id', Auth::id())->get();

        return view('deposits.deposits', ['deposits' => $list_deposits]);
    }



    function fetch(Request $request)
    {
     $select = $request->get('select');
     $value = $request->get('value');
     $dependent = $request->get('dependent');

     $data = Currency::where('compatible_with', 'like', '%' . $value . '%')->get();

     if($data->count() > 1){
        $output = '<option value="">Select Currency</option>';
     }else{
        $output = '';
     }

     foreach($data as $row)
     {
      $output .= '<option value="'.$row->name.'">'.$row->name.'</option>';
     }
     echo $output;
    }





    // Show a deposit
    public function show($id){
        $deposit = Deposit::find($id);

        $this->authorize('view', $deposit);

        return view('deposits.deposit_details', ['deposit' => $deposit]);
    }









    // Create Deposit
    public function create(){

        $payment_methods = PaymentMethod::all();
        $currencies = Currency::all();

    	return view('deposits.create', ['payment_methods' => $payment_methods, 'currencies' => $currencies]);
    }








    // Save Deposit
    public function store(depositRequest $Request){


        $deposit = new Deposit;
        $deposit->user_id       = Auth::user()->id;
        $deposit->p_method   = $Request->input('p_method');
        $deposit->p_info   = $Request->input('p_info');
        $deposit->currency   = $Request->input('currency');
        $deposit->amount        = $Request->input('amount');
        $deposit->send_date     = $Request->input('send_date');
        if($Request->file('img') !== null){
        $deposit->img_path      = $Request->file('img')->store('deposits/'.date('M').''.date('Y').'');
        }
        
		$queue = Deposit::where('the_status', 'open')->count();
        $deposit->the_queue     = $queue+1;
        $deposit->save();

        $this->order();

        session()->flash('success', 'The deposit has been created.');
        
        $this->createNotification(Auth::id(),'depositCreated','',url('deposit/'.$deposit->id));

        return redirect('deposit/'.$deposit->id);
    }








    // edit Deposit
    public function edit(){

    }









    // Cancel deposit
    public function cancel($id){
        $deposit = Deposit::find($id);

        $this->Authorize('cancel', $deposit);

        $deposit->the_status = "Canceled";
        $deposit->the_queue = 0;
        $deposit->save();

        $this->order();

        session()->flash('success', 'The deposit has been cancelled.');
        
        $this->createNotification(Auth::id(),'youCancelledDeposit','',url('deposit/'.$deposit->id));

        return redirect('deposit/'.$id.'');
    }

	// Urgent verification
    public function urgent_verification($id){
        $deposit = Deposit::find($id);

        $this->Authorize('urgent_verification', $deposit);

        $deposit->the_queue = 1;
        $deposit->urgent_verification = 1;
        $deposit->save();

        $this->order();

        session()->flash('success', 'The deposit has been updated.');

        return redirect('deposit/'.$id.'');
    }


}
