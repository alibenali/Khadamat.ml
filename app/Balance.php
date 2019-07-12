<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;

class Balance extends Model
{
	use CausesActivity, LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logName = 'Balance'; 


    public function user(){
    	return $this->belongsTo('App\user');
    }
}
