<?php

namespace App\Policies;

use App\user;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class ProfilePolicy
{
    use HandlesAuthorization;


    public function edit(User $user, User $profile){
    	return $user->id == $profile->id;
    }

    public function update(User $user, User $profile){
    	return $user->id == $profile->id;
    }
}
