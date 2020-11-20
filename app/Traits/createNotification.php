<?php

namespace App\Traits;
use App\Notification;

trait createNotification {

	public function createNotification($user_id, $title, $content, $url)
	{
    	$notification = new Notification;

    	$notification->to_user = $user_id;
        $notification->title = $title;
        $notification->content = $content;
        $notification->url = $url;

    	$notification->save();

    }

}