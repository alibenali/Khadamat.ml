<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Auth;

class NotificationController extends Controller
{
    public function store(Request $request){
    	$notification = new Notification;
		$notification->url = $request->input('url');
    	$notification->title = $request->input('title');
    	$notification->content = $request->input('content');
    	$notification->save();
    }


    public function seen(Request $request){
    	$notification = Notification::where('to_user', Auth::id())->update(['seen' => 1]);
    }
}
