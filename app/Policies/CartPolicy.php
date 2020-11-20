<?php

namespace App\Policies;

use App\User;
use App\Cart;

use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class CartPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function delete(User $user, Cart $cart){
        return $cart->user_id == Auth::id();
    }
}
