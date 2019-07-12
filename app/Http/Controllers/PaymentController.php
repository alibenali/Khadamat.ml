<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Balance;
use App\Payment;
use App\Conversation;
use App\Message;
use Auth;
use App\user;
use App\Http\Requests\paymentRequest;
use App\Http\Requests\acceptPaymentRequest;
use App\Traits\balance_to_hold;
use App\Traits\trait_conversation;

class PaymentController extends Controller
{


    // Logined if not go login 
    public function __construct(){
        $this->middleware('auth');
    }

    // use the trait tp convert balance to hold
	use balance_to_hold;
    // use the trait to create conversation
	use trait_conversation;


    public function index(){

        if( Auth::user()->is_admin){
        $payments = Payment::where('the_status', 'Open')->orderBy('id', 'desc')->get();
        }else{
        $payments = Payment::where('user_id', Auth::id())->get();
        }

        return view('payments.index', ['payments' => $payments]);
    }

    public function show($id){
        $payment = Payment::find($id);
        $conversation = Conversation::where('payment_id', $payment->id)->first();

        return redirect('conversation/'.$conversation->id.'');
    }

	public function confirm($id){

		$service = Service::find($id);
		$balance = Auth::user()->balances->first();

		if($balance == NULL){

			session(['URL' => url()->current()]);
			session()->flash('danger', 'You didn\'t create the currencyes yet, Please create the currencyes.');
			return redirect('home');
		}

		$p_method = strtolower($service->p_method.'_'.$service->currency);
		$balance = $balance->$p_method;


		$new_bal = $balance - $service->price;

		if($balance >= $service->price){
			$msj = "";
			$status = "";
		}else{
			$msj = "Sorry, you don't have enough balance";
			$status = "disabled";
		}

		return view('payments.confirm', ['service' => $service, 'balance' => $balance, 'new_bal' => $new_bal, 'status' => $status, 'msj' => $msj]);
	}


	public function store(paymentRequest $request){
		$payment = new Payment;

		$payment->user_id = Auth::user()->id;
		$payment->service_id = $request->input('service_id');
		$payment->conversation_id = '0';

		$service_id = $request->input('service_id');
		$service = Service::find($service_id);

		$balance = Auth::user()->balances->first();


		$payment->quantity = $request->input('quantity');


		$payment_method = strtolower($service->p_method.'_'.$service->currency);

		$payment->payment_method = $service->p_method;
		$payment->currency = $service->currency;

		$payment->price = $service->price;
		$payment->fees = $service->fees;
		$payment->current_balance = $balance->$payment_method;

		// Calculating new balance (fees + price*quantity)
		$total = ($payment->fees + ($service->price * $payment->quantity));
		$payment->total = $total;

		// Checking if you have enough balance
		if($balance->$payment_method >= $total){
			$new_balance = $balance->$payment_method - $total;
		}else{
			$index = url('home');
			header('location: '.$index.'');
			exit();
		}
		$payment->new_balance = $new_balance;

		// Calling to the method to convert  balance to hold
		$this->balance_to_hold(Auth::user()->id, $payment_method, $new_balance);

		$payment->save();

		$payment_id = $payment->id;

		// Calling to the method to create conversation
		$this->store_conversation(Auth::user()->id, $service_id, $payment_id);

	}



	public function accept(acceptPaymentRequest $request){


		$payment_id = $request->input('payment_id');
		$payment = Payment::find($payment_id);
		$this->authorize('accept', $payment);

        $conversation = Conversation::where('payment_id', $payment->id)->first();

        $balance = Balance::where('user_id', $payment->user_id)->first();

		$payment_method = strtolower($payment->payment_method.'_'.$payment->currency);

		
        $hold_p_method = strtolower('hold_'.$payment_method);

        $balance->$hold_p_method = $balance->$hold_p_method - $payment->total;
		$payment->the_status = "accepted";
		$conversation->the_status = "accepted";
		$conversation->save();
		$payment->save();
		$balance->save();
		// Create new mesasge
		$message = new Message;
		$message->user_id = 0;
		$message->conversation_id = $conversation->id;
		$message->content = "The payment has been accepted";
		$message->save();

		return redirect('admin/conversation/'.$conversation->id.'');
	}


	public function refuse(acceptPaymentRequest $request){


		$payment_id = $request->input('payment_id');
		$raison = $request->input('raison');
		$payment = Payment::find($payment_id);
		$this->authorize('refuse', $payment);

        $conversation = Conversation::where('payment_id', $payment->id)->first();

        $balance = Balance::where('user_id', $payment->user_id)->first();


		$payment_method = strtolower($payment->payment_method.'_'.$payment->currency);

		
        $hold_p_method = strtolower('hold_'.$payment_method);

        $balance->$hold_p_method = $balance->$hold_p_method - $payment->total;
        $balance->$payment_method = $balance->$payment_method + $payment->total;

		$payment->the_status = "refused";
		$conversation->the_status = "refused";
		$conversation->save();
		$payment->save();
		$balance->save();
		// Create new mesasge
		$message = new Message;
		$message->user_id = 0;
		$message->conversation_id = $conversation->id;
		$message->content = "The payment has been refused. Reason:  ".$raison;
		$message->save();

		return redirect('admin/conversation/'.$conversation->id.'');
	}

}
