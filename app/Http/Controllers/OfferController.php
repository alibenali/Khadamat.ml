<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\Message;
use App\Payments_offer;
use App\Balance;
use Auth;

class OfferController extends Controller
{


	public function accept(Request $request){
        $offer_id = $request->input('offer_id');
        $offer   = Payments_offer::where('id', $offer_id)->firstOrFail();

        $this->authorize('accept', $offer);

        $p_method = $offer->pm_slug;
        $hold_p_method = 'hold_'.$p_method;

        $balance = Balance::where('user_id', Auth::id())->firstOrFail();
        $balance->$p_method = $balance->$p_method - $offer->price;
        $balance->$hold_p_method = $balance->$hold_p_method + $offer->price;
        $balance->save();


        $offer->the_status = 'paid';
        $offer->save();

    }


	public function store(Request $request){


    	$conversation = Conversation::find($request->input('conversation_id'));

    	$offer = new Payments_offer;

        $this->authorize('create', $offer);

    	$offer->user_id =  $conversation->user_id;
    	$offer->conversation_id = $conversation->id;
    	$offer->payment_id = $conversation->payment_id;
    	$offer->title = $request->input('title');
    	$offer->details = $request->input('details');
    	$pm_slug = strtolower($request->input('p_method').'_'.$request->input('currency'));
    	$offer->pm_slug = $pm_slug;
    	$offer->p_method = $request->input('p_method');
    	$offer->currency = $request->input('currency');
    	$offer->price = $request->input('price');
    	$offer->save();

		$number_offers = Payments_offer::where('conversation_id', $request->input('conversation_id'))->count();

    	$message = new Message;

    	$message->user_id = Auth::id();
    	$message->conversation_id = $request->input('conversation_id');
    	$message->the_type = 'offer';
        $message->seen_by_sender = 1;
    	$message->content = $number_offers;

    	$message->save();

    	return redirect(url()->previous());
    }
}
