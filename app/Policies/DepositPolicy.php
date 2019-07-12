<?php

namespace App\Policies;

use App\User;
use App\Deposit;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class DepositPolicy extends \TCG\Voyager\Policies\BasePolicy
{
    use HandlesAuthorization;



    /**
     * Determine whether the user can view the deposit.
     *
     * @param  \App\User  $user
     * @param  \App\Deposit  $deposit
     * @return mixed
     */
    public function view(User $user, Deposit $deposit)
    {
        return $user->id == $deposit->user_id;
    }

    /**
     * Determine whether the user can create deposits.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the deposit.
     *
     * @param  \App\User  $user
     * @param  \App\Deposit  $deposit
     * @return mixed
     */
    public function update(User $user, Deposit $deposit)
    {
        //
    }



    public function accept(User $user, Deposit $deposit)
    {
        if(Auth::user()->hasRole('admin')){
         		return $deposit->the_status == "Open";
         }else{
         	return false;
         }
    }

    public function refuse(User $user, Deposit $deposit)
    {
        if(Auth::user()->hasRole('admin')){
         	return $deposit->the_status != "Refused";
         }else{
         	return false;
         }
    }

    /**
     * Determine whether the user can delete the deposit.
     *
     * @param  \App\User  $user
     * @param  \App\Deposit  $deposit
     * @return mixed
     */
    public function delete(User $user, Deposit $deposit)
    {
        //
    }

    /**
     * Determine whether the user can restore the deposit.
     *
     * @param  \App\User  $user
     * @param  \App\Deposit  $deposit
     * @return mixed
     */
    public function restore(User $user, Deposit $deposit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the deposit.
     *
     * @param  \App\User  $user
     * @param  \App\Deposit  $deposit
     * @return mixed
     */
    public function forceDelete(User $user, Deposit $deposit)
    {
        //
    }



    public function cancel(User $user, Deposit $deposit){
        return $user->id == $deposit->user_id;
    }

    public function urgent_verification(User $user, Deposit $deposit){

    	$count_urgnet_verification = Deposit::where('user_id', Auth::id())->where('urgent_verification', 1)->where('created_at', 'like', date("Y-m").'%')->count();

        if($user->id == $deposit->user_id AND $count_urgnet_verification <= 1){
        	return true;
        }else{
        	return false;
        }
    }
}
