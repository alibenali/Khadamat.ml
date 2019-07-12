<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;
use App\Payment;

class PaymentPolicy extends \TCG\Voyager\Policies\BasePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function before($user, $ability) {
    if (Auth::user()->hasRole('admin')) {
        return true;
    }
	}


    public function accept(User $user, Payment $payment){
        return $user->id == $payment->creator_id;
    }

    public function refuse(User $user, Payment $payment){
        return $user->id == $payment->creator_id;
    }

    public function create_offer(User $user, Payment $payment){
        return $user->id == $payment->creator_id;
    }
}
