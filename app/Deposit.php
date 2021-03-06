<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;

class Deposit extends Model
{




    use CausesActivity, LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logName = 'deposit'; 
}
