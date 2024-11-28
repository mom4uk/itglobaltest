<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteStopSequence;
use App\Models\Bus;
use App\Models\Stop;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function find(Request $request) {
        $route = new Route();
        $req = [4, 1]; // add error output for null if there are no routes with this stops, cannot be the same 1 and 1 for exmp (validation)

        $routesRaw = RouteStopSequence::select('route_id')
            ->whereIn('stop_id', [1, 4])
            ->groupBy('route_id')
            ->havingRaw('COUNT(stop_id) > ?', [1])
            ->get()
            ->toArray();
        $routes = array_map(fn($item) => $item['route_id'], $routesRaw);

        $numOfStops = RouteStopSequence::selectRaw('route_id, COUNT(stop_id) AS number_stops')
            ->whereIn('route_id', $routes)
            ->groupBy('route_id')
            ->get()
            ->toArray();

        $buses = Bus::whereIn('route_id', $routes)->get()->toArray();
        $schedule = Route::whereIn('id', $routes)->get()->toArray();
        $stops = RouteStopSequence::
        select('stops.name', 'route_stop_sequences.route_id', 'route_stop_sequences.stop_id', 'route_stop_sequences.sequence')
            ->join('stops','stop_id','=','id')
            ->whereIn('route_id',[1, 2])
            ->get()
            ->toArray();

        $data = [$numOfStops, $schedule, $buses, $stops, $req];
        $buses = $route->findBuses($data);
        dump($buses);
        return view('welcome', compact('buses'));
    }
}
