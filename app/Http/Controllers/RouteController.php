<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteStopSequence;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function find(Request $request) {
        $route = new Route();
        $req = [1, 4]; // add error output for null if there are no routes with this stops, cannot be the same 1 and 1 for exmp (validation)

        $routesRaw = RouteStopSequence::select('route_id')
            ->whereIn('stop_id', $req)
            ->groupBy('route_id')
            ->havingRaw('COUNT(stop_id) > ?', [1])
            ->get()
            ->toArray();
        $routes = array_map(fn($item) => $item['route_id'], $routesRaw);

        $normalizedData = array_map([$this, 'normalizeRouteData'], $routes);
        $buses = $route->findBuses($normalizedData, $req);
        return view('welcome', compact('buses'));
    }

    private function normalizeRouteData($id)
    {
        $routeData = RouteStopSequence::
            select(
                'route_stop_sequences.route_id',
                'route_stop_sequences.stop_id', 
                'route_stop_sequences.sequence', 
                'stops.name', 
                'buses.number as bus_number', 
                'initial_stop_departure_time', 
                'final_stop_departure_time',
                'minutes_between_stops')
            ->join('stops','route_stop_sequences.stop_id','=','stops.id')
            ->join('routes','route_stop_sequences.route_id','=','routes.id')
            ->join('buses','route_stop_sequences.route_id','=','buses.route_id')
            ->where('route_stop_sequences.route_id','=', $id)
            ->get()
            ->toArray();

        return ['id' => $id, 'data' => $routeData];
    }
}
