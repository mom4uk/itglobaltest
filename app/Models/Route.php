<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    private $minutesBetweenStops = 40;

    public function findBuses($stops): string {
        $currentTime = '12'; // find current time
        $routes = []; // here some routes
        return '';
    }
}
