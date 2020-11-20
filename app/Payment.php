<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;

class Payment extends Model
{

	use CausesActivity, LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logName = 'Payment'; 

    public function user(){
    	return $this->belongsTo('App\user');
    }


    public function conversation(){
    	return $this->hasMany('App\Conversation');
    }


    public function service(){
    	return $this->belongsTo('App\Service');
    }
}
