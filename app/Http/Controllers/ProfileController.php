<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\History_profile;

class ProfileController extends Controller
{
    





	public function edit($id){

		$user = User::find($id);

		$profile = $user;

		$this->authorize('edit', $profile);

		return view('profile.edit', ['user' => $user]);
	}


	public function update(Request $request,$id){

		$user = User::find($id);

		$profile = $user;
		$this->authorize('update', $profile);

		$user->name = $request->input('name');
		$user->phone = $request->input('phone');
		$user->email = $request->input('email');

		$user->save();

		$this->store($id);

		session()->flash('success', 'The profile has been updated.');

		return view('profile.edit', ['user' => $user]);
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
