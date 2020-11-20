<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Conversation;
use App\Message;
use App\Service;
use App\Payment;
use App\Balance;
use App\Payments_offer;
use App\Rating;

use Carbon\carbon;
use Session;

class ConversationController extends Controller
{
    public function index(){

    }

    public function show($id){

    	$conversation = Conversation::find($id);
		
		$this->authorize('view', $conversation);

    	$messages = Message::where('conversation_id', '=', $id)->orderBy('id', 'asc')->get();
    	$service = Service::where('id', '=', $conversation->service_id)->firstOrFail();
    	$payment = Payment::where('id', '=', $conversation->payment_id)->firstOrFail();
		$balance = Balance::where('user_id', '=', $conversation->user_id)->firstOrFail();
        $offer   = Payments_offer::where('conversation_id', '=', $conversation->id)->get();
        $user_id = Auth::id();

        $update_messages = Message::where('conversation_id', '=', $id)->where('user_id', '!=', Auth::id())->update(['seen_by_receiver' => 1]);
        $update_my_messages = Message::where('conversation_id', '=', $id)->where('user_id', '=', Auth::id())->update(['seen_by_sender' => 1]);

		$payment_method = strtolower($service->p_method.'_'.$service->currency);


    	$hold_balance = 'hold_'.$payment_method;

        $payments_offer = Payments_offer::where('payment_id',$payment->id)->where('the_status', 'paid')->get();

        $offers_price = 0;
        foreach($payments_offer as $offer2){
            $offers_price += $offer2->price;
        }


        // Start Rating Section
        $rating = 'noRating';

        $rating = Rating::where('service_id', $service->id)->where('conversation_id', $payment->conversation_id)->where('user_id', Auth::id())->count();

        if($rating == 1){
            $rating = Rating::where('service_id', $service->id)->where('conversation_id', $payment->conversation_id)->where('user_id', Auth::id())->first();
        }else{
            $rating = 'noRating';
        }


    	return view('conversations.show', ['messages' => $messages, 'conversation' => $conversation, 'service' => $service, 'payment' => $payment, 'balance' => $balance ,'hold_balance' => $hold_balance, 'offer' => $offer, 'user_id' => $user_id, 'offers_price' => $offers_price, 'rating' => $rating]);
    }



    public function fetch(Request $request)
    {


     $conversation_id = $request->get('conversation_id');
     $last_msj_id = $request->get('last_msj_id');

    $conversation = Conversation::find($conversation_id);
    $this->authorize('view', $conversation);

     $message = Message::where('conversation_id', $conversation_id)->where(function ($query) {
                $query->where('seen_by_sender', '=', 0)
                      ->orWhere('seen_by_receiver', '=', 0);
            })->first();

     if($message == NULL){
        return;
     }

     if($message->user_id == Auth::id()){
        $seen = 'seen_by_sender';
     }else{
        $seen = 'seen_by_receiver';
     }

     
        if($message->the_type == "message"){

            $message->$seen = 1;
            $message->save();  

            return response()->json([
                'id' => $message->id,
                'user_id' => $message->user_id,
                'type' => $message->the_type,
                'content' => $message->content,
                'created_at' => $message->created_at->format('Y-m-d, H:i')

            ]);
                       
        }elseif($message->the_type == "offer"){
            $offer   = Payments_offer::where('conversation_id', '=', $conversation_id)->orderBy('id', 'desc')->first();

            $message->$seen = 1;
            $message->save(); 

            return response()->json([
                'id' => $message->id,
                'user_id' => $message->user_id,
                'type' => $message->the_type,
                'id' => $offer->id,
                'title' => $offer->title,
                'price' => $offer->price,
                'currency' => $offer->currency,
                'p_method' => $offer->p_method,
                'details' => $offer->details,
                'the_status' => $offer->the_status,
                'created_at' => $message->created_at->format('Y-m-d, H:i')

            ]);

        }
    }


}
