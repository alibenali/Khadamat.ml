<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class UserPolicy
{
    use HandlesAuthorization;



    public function edit(User $user, Profile $profile){
        return Auth::id() == $user->id;
    }
}
