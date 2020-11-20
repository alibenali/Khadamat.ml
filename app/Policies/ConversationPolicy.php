<?php

namespace App\Policies;

use App\User;
use App\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class ConversationPolicy extends \TCG\Voyager\Policies\BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the conversation.
     *
     * @param  \App\User  $user
     * @param  \App\Conversation  $conversation
     * @return mixed
     */

    public function before(User $user){
        if(Auth::user()->hasRole('admin')){
            return true;
        }
    }

    public function view(User $user, Conversation $conversation)
    {
        
        if($conversation->payment->creator_id == Auth::id()){
            return true;
        }

        return $user->id == $conversation->user_id;
    }

    /**
     * Determine whether the user can create conversations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the conversation.
     *
     * @param  \App\User  $user
     * @param  \App\Conversation  $conversation
     * @return mixed
     */
    public function update(User $user, Conversation $conversation)
    {
        return $user->id == $conversation->user_id;
    }

    /**
     * Determine whether the user can delete the conversation.
     *
     * @param  \App\User  $user
     * @param  \App\Conversation  $conversation
     * @return mixed
     */
    public function delete(User $user, Conversation $conversation)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the conversation.
     *
     * @param  \App\User  $user
     * @param  \App\Conversation  $conversation
     * @return mixed
     */
    public function restore(User $user, Conversation $conversation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the conversation.
     *
     * @param  \App\User  $user
     * @param  \App\Conversation  $conversation
     * @return mixed
     */
    public function forceDelete(User $user, Conversation $conversation)
    {
        //
    }
}
