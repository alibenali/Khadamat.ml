<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rating;
use App\Service;
use App\Http\Requests\ratingRequest;
use Auth;
use Illuminate\Support\Facades\DB;
class RatingController extends Controller
{
    public function rateService(ratingRequest $request){

    	

    	$rating = new Rating;
		
		$this->authorize('ratingExist', [$rating, $request->input('service_id'), $request->input('conversation_id')]);

    	$rating->user_id = Auth::id();
    	$rating->service_id = $request->input('service_id');
        $rating->conversation_id = $request->input('conversation_id');
    	$rating->num_stars = $request->input('num_stars');
    	$rating->comment = $request->input('comment');

    	$rating->save();

    	$service = Service::where('id', $request->input('service_id'))->update(['num_stars'=> DB::raw('num_stars+'.$rating->num_stars), 'num_raters'=> DB::raw('num_raters+1')]);

    	return redirect()->back();
    }
}
