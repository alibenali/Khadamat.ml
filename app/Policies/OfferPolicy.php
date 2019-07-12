<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Payments_offer;

class OfferPolicy
{
    use HandlesAuthorization;


        public function create(User $user){
            return $user->is_admin;
        }

        public function accept(User $user, Payments_offer $offer){
            return $user->id == $offer->user_id;
        }
    
}
