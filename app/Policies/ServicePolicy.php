<?php

namespace App\Policies;

use App\User;
use App\Service;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class ServicePolicy extends \TCG\Voyager\Policies\BasePolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view the service.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $service
     * @return mixed
     */


    public function before(){
    	if(Auth::user()->hasRole('admin')){
    		return true;
    	}
    }

 
	public function read(User $user, Service $service)
    {
        return $service->creator_id == Auth::id();
    }


    public function edit(User $user, Service $service)
    {
        return $service->creator_id == Auth::id();
    }

    /**
     * Determine whether the user can create services.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
      // return $user->is_admin;  
    }

    /**
     * Determine whether the user can update the service.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $service
     * @return mixed
     */
    public function update(User $user, Service $service)
    {
        return $service->creator_id == Auth::id();
        //
    }

    /**
     * Determine whether the user can delete the service.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $service
     * @return mixed
     */
    public function delete(User $user, Service $service)
    {
        return $service->creator_id == Auth::id();
        //
    }

    /**
     * Determine whether the user can restore the service.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $service
     * @return mixed
     */
    public function restore(User $user, Service $service)
    {
        return $service->creator_id == Auth::id();
        //
    }

    /**
     * Determine whether the user can permanently delete the service.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $service
     * @return mixed
     */
    public function forceDelete(User $user, Service $service)
    {
        return $service->creator_id == Auth::id();
        //
    }
}
