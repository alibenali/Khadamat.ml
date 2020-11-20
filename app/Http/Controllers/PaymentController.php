<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Balance;
use App\Payment;
use App\Conversation;
use App\Message;
use App\Payments_offer;
use App\Cart;
use App\BalanceHistory;
use Auth;
use App\user;
use App\Http\Requests\paymentRequest;
use App\Http\Requests\acceptPaymentRequest;
use App\Traits\trait_conversation;
use App\Traits\createNotification;
use App\Traits\balanceTrait;

class PaymentController extends Controller
{



	use balanceTrait;
    // use the trait to create conversation
	use trait_conversation;
	// use the trait to create notification
	use createNotification;


    public function index(){

        $payments = Payment::where('user_id', Auth::id())->get();
        

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
			session()->flash('danger', __('profile.noBalance'));
			return redirect('home');
		}

		$p_method = strtolower($service->p_method.'_'.$service->currency);
		$balance = $balance->$p_method;


		$total = $service->price + $service->fees;

		if($balance >= $service->price){
			$msj = "";
			$status = "";
		}else{
			$msj = "enoughBalance";
			$status = "disabled";
		}

		$count_cart = Cart::where('service_id', $service->id)->where('the_status', '!=', 'deleted')->count();
		if($count_cart == 0){
			$cart = new Cart;
			$cart->user_id = Auth::id();
			$cart->service_id = $service->id;
			$cart->save();
		}

		return view('payments.confirm', ['service' => $service, 'balance' => $balance, 'total' => $total, 'status' => $status, 'msj' => $msj]);
	}


	public function store(paymentRequest $request){
		$payment = new Payment;

		$payment->user_id = Auth::user()->id;
		$payment->service_id = $request->input('service_id');
		$payment->conversation_id = '0';

		$service_id = $request->input('service_id');
		$service = Service::find($service_id);

		$payment->creator_id = $service->creator_id;

		$balance = Auth::user()->balances->first();


		$payment->quantity = $request->input('quantity');


		$payment_method = strtolower($service->p_method.'_'.$service->currency);
		$hold_p_method = strtolower('hold_'.$service->p_method.'_'.$service->currency);

		$payment->payment_method = $service->p_method;
		$payment->currency = $service->currency;

		$payment->price = $service->price;
		$payment->fees = $service->fees;
		$payment->current_balance = $balance->$payment_method;

		// Calculating new balance (fees + price*quantity)
		$total = ($payment->fees + ($service->price * $payment->quantity));
		$payment->total = $total;

		// Checking if you have enough balance
		if($this->enough(Auth::id(), $payment_method, $total)){

		$payment->new_balance = $balance->$payment_method - $total;
		$payment->save();
		$payment_id = $payment->id;
		$balance_amount = ($service->fees + ($service->price * $payment->quantity));
        $this->balanceDown(Auth::id(), $payment_method, $balance_amount, "Payment created", "conversation/".$payment_id);
        $this->balanceUp(Auth::id(), $hold_p_method, $balance_amount, "Payment created", "conversation/".$payment_id);
		// Calling to the method to create conversation
		$this->store_conversation(Auth::user()->id, $service_id, $payment_id);

		}else{
			$index = url('home');
			header('location: '.$index.'');
			exit();
		}


	}






	public function cancel(acceptPaymentRequest $request){

		$payment_id = $request->input('payment_id');
		$payment = Payment::find($payment_id);

		$this->authorize('cancel', $payment);


		$payments_offer = Payments_offer::where('payment_id',$payment_id)->where('the_status', 'paid')->get();

		foreach($payments_offer as $offer){
			
		$this->balanceUp($offer->user_id, $offer->pm_slug, $offer->price, "Offer refunded", "coversation/".$payment->id);
		$this->balanceDown($offer->user_id, 'hold_'.$offer->pm_slug, $offer->price, "Offer refunded", "coversation/".$payment->id);

		}

        $conversation = Conversation::where('payment_id', $payment->id)->first();

        $balance = Balance::where('user_id', $payment->user_id)->first();

		$payment_method = strtolower($payment->payment_method.'_'.$payment->currency);
        $hold_p_method = strtolower('hold_'.$payment_method);

		$payment->the_status = "cancelled";
		$conversation->the_status = "cancelled";
		$conversation->save();
		$payment->save();

		// Create new mesasge
		$message = new Message;
		$message->user_id = 0;
		$message->conversation_id = $conversation->id;
		$message->content = "The payment has been cancelled.";
		$message->save();

        $this->createNotification(Auth::id(),'youCancelledPayment','','conversation/'.$conversation->id);

		$this->balanceDown($payment->user_id, $hold_p_method, $payment->total, "Payment canceled", "coversation/".$payment->id);
		$this->balanceUp($payment->user_id, $payment_method, $payment->total, "Payment canceled", "coversation/".$payment->id);

		return redirect('conversation/'.$conversation->id.'');
	}

}
