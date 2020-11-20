<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\Message;
use App\Payment;
use App\Payments_offer;
use App\Balance;
use App\BalanceHistory;
use Auth;
use App\Traits\createNotification;
use App\Traits\balanceTrait;

class OfferController extends Controller
{

    use createNotification;
    use balanceTrait;


	public function accept(Request $request){
        $offer_id = $request->input('offer_id');
        $offer   = Payments_offer::where('id', $offer_id)->firstOrFail();


        $this->authorize('accept', $offer);

        $p_method = $offer->pm_slug;
        $hold_p_method = 'hold_'.$p_method;

        $balance = Balance::where('user_id', Auth::id())->firstOrFail();

        $balance_amount = $offer->price;
        $offer->the_status = 'paid';
        $offer->save();

        $this->balanceDown(Auth::id(), $p_method, $balance_amount, "Offer accepted", "conversation/".$offer->payment_id);
        $this->balanceUp(Auth::id(), $hold_p_method, $balance_amount, "Offer accepted", "conversation/".$offer->payment_id);

        return redirect(url()->previous());

    }


	public function store(Request $request){


    	$conversation = Conversation::find($request->input('conversation_id'));

    	$offer = new Payments_offer;

        $payment = Payment::where('conversation_id', $conversation->id)->first();
        $this->authorize('create_offer', $payment);

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

        $this->createNotification($conversation->user_id,'youReceivedAnOffer','',url('conversation/'.$conversation->id));


    	return redirect(url()->previous());
    }
}
