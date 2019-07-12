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

class DepositController extends Controller
{

    // Logined if not go login 
    public function __construct(){
        $this->middleware('auth');
    }



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

    // Accept deposit
    public function accept(Request $request){
    	$id = $request->input('id');
        $deposit = Deposit::find($id);
        $balance = Balance::where('user_id', $deposit->user_id)->first();

        $this->Authorize('accept', $deposit);

		$payment_method = strtolower($deposit->sold_method);

		$balance->$payment_method = $balance->$payment_method + $request->input('amount');
		$balance->save();

        $deposit->the_status = "Accepted";
        $deposit->amount = $request->input('amount');
        $deposit->save();

        $this->order();

        session()->flash('success', 'The deposit has been accepted.');

        return redirect('deposit/'.$id.'');
    }


    // Refuse deposit
    public function refuse(Request $request){
    	$id = $request->input('id');
        $deposit = Deposit::find($id);

        $deposit->the_status = "Refused";
        $deposit->save();

        $this->order();
        
        session()->flash('success', 'The deposit has been refused.');
    }

    // Delete Deposit
    public function destroy(){

    }

}
