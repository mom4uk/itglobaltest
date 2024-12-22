<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteStopSequence extends Model
{
    
    protected $fillable = ['route_id', 'stop_id', 'sequence_forward', 'sequence_backward'];
    //
}
