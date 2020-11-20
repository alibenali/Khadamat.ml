<?php

namespace App\Policies;

use App\User;
use App\Rating;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
{
    use HandlesAuthorization;


    public function ratingExist(User $user, Rating $rating, $service_id, $conversation_id){
        $rating = Rating::where('service_id', $service_id)->where('conversation_id', $conversation_id)->where('user_id', $user->id)->count();

            return $rating == 0;
    }
}
