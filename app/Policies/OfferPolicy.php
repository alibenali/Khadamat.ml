<?php

namespace App\Policies;

use App\User;
use App\Payment;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Payments_offer;
use App\Conversation;
use Auth;

class OfferPolicy
{
    use HandlesAuthorization;

	    public function before(User $user){
	       /* if(Auth::user()->hasRole('admin')){
	            return true;
	        } */
	    }

        public function accept(User $user, Payments_offer $offer){
            if($offer->the_status == 'waiting agreement'){
                $conversation = Conversation::find($offer->conversation_id);
                if($conversation->the_status == 'open' OR $conversation->the_status == 'pending')
                {
                    return $user->id == $offer->user_id;
                }
            }
            return false;
        }


}
