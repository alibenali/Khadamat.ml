<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Balance;
use Auth;

class BalancePolicy
{
    use HandlesAuthorization;

    public function create(){

    	$balance = Balance::where('user_id', Auth::id())->get()->count();
    	return $balance == 0;
    }
}
