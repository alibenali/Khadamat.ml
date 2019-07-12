<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\Message;
use Auth;
use App\Http\Requests\messageRequest;
use App\Payments_offer;

class MessageController extends Controller
{
    public function store(messageRequest $request){



    	$message = new Message;

    	$message->user_id = Auth::user()->id;
    	$message->conversation_id = $request->input('conversation_id');
    	$message->content = $request->input('message');

    	$message->save();

    	return redirect(url()->previous());
    }

    public function ajax_store(Request $request){
    	$message = new Message;
    	$message->user_id = Auth::user()->id;
    	$message->conversation_id = $request->get('conversation_id');
    	$message->content = $request->get('message');  
    	$message->save();  

    }

}
