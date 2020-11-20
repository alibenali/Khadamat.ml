<?php

namespace App\Policies;

use App\User;
use App\Withdraw;
use Illuminate\Auth\Access\HandlesAuthorization;

class WithdrawPolicy extends \TCG\Voyager\Policies\BasePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){

    }

    /**
     * Determine whether the user can view the withdraw.
     *
     * @param  \App\User  $user
     * @param  \App\Deposit  $withdraw
     * @return mixed
     */
    public function view(User $user, Withdraw $withdraw)
    {
        return $user->id == $withdraw->user_id;
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
     * Determine whether the user can update the withdraw.
     *
     * @param  \App\User  $user
     * @param  \App\Withdraw  $withdraw
     * @return mixed
     */
    public function update(User $user, Withdraw $withdraw)
    {
        //
    }



    public function accept(User $user, Withdraw $withdraw)
    {
        return $withdraw->the_status == "pending";
    }

    public function pending(User $user, Withdraw $withdraw)
    {
        return $withdraw->the_status == "open";
    }


    public function refuse(User $user, Withdraw $withdraw)
    {
        return $withdraw->the_status == "pending";
    }

    /**
     * Determine whether the user can delete the withdraw.
     *
     * @param  \App\User  $user
     * @param  \App\Withdraw  $withdraw
     * @return mixed
     */
    public function delete(User $user, Withdraw $withdraw)
    {
        //
    }

    /**
     * Determine whether the user can restore the withdraw.
     *
     * @param  \App\User  $user
     * @param  \App\Withdraw  $withdraw
     * @return mixed
     */
    public function restore(User $user, Withdraw $withdraw)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the withdraw.
     *
     * @param  \App\User  $user
     * @param  \App\Withdraw  $withdraw
     * @return mixed
     */
    public function forceDelete(User $user, Withdraw $withdraw)
    {
        //
    }



    public function cancel(User $user, Withdraw $withdraw){
        return $user->id == $withdraw->user_id;
    }
}
