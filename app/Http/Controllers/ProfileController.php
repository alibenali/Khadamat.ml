<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Service;
use App\History_profile;
use App\Http\Requests\profileRequest;
use Auth;
use App\Balance;
use App\Traits\createNotification;

class ProfileController extends Controller
{
    
	use createNotification;


	public function show($id){

		$user = User::find($id);
		$services = Service::where('creator_id', $user->id)->get();

		$num_raters = 0;
		$num_stars = 0;

		foreach($services as $service){
			$num_raters = $num_raters + $service->num_raters;
			$num_stars = $num_stars + $service->num_stars; 
		}

        return view('profile.show', ['user' => $user, 'services' => $services, 'num_raters' => $num_raters, 'num_stars' => $num_stars ]);
	}

	public function edit($id){

		$user = User::find($id);

		$profile = $user;

		$this->authorize('edit', $profile);

		return view('profile.edit', ['user' => $user]);
	}


	public function update(ProfileRequest $request,$id){

		$user = User::find($id);

		$profile = $user;
		$this->authorize('update', $profile);

		$user->name = $request->input('name');
		$user->phone = $request->input('phone');
		$user->phone_country = $request->input('phone_country');
		$user->birthday = $request->input('birthday');
		$user->address = $request->input('address');
		$user->email = $request->input('email');

		$user->save();

		$this->store($id);

		session()->flash('success', 'The profile has been updated.');

        $this->createNotification(Auth::id(),'yourProfileUpdated','',url('home'));


		return view('profile.edit', ['user' => $user]);
	}


	public function update_pic(Request $request){

		$request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        $avatarName = 'users/'.date('M').date('Y').'/'.$user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();

        $request->avatar->storeAs('',$avatarName);

        $user->avatar = $avatarName;
        $user->save();

        return back()
            ->with('success','You have successfully upload image.');
	}

	// Store history profile
	public function store($id){

		$user = User::find($id);
		$profile = new History_profile;

		$profile->user_id = $id;
		$profile->name = $user->name;
		$profile->phone = $user->phone;
		$profile->email = $user->email;

		$profile->save();

	}

}
