<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;

class Cart extends Model
{
    use CausesActivity, LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logName = 'Cart';

    public function user(){
    	return $this->belongsTo('App\user');
    }

    public function service(){
    	return $this->belongsTo('App\Service');
    }
}
