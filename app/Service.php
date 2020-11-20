<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use CausesActivity, LogsActivity, SoftDeletes;
    protected static $logAttributes = ['*'];
    protected static $logName = 'Balance'; 
    
    protected $dates = ['deleted_at'];


    public function user(){
    	return $this->belongsTo('App\User', 'creator_id');
    }

    public function cart(){
        return $this->hasMany('App\Cart');
    }

    public function payment(){
        return $this->hasMany('App\Payment');
    }
}

