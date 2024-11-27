<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteStopSequence;
use App\Models\Bus;
use App\Models\Stop;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function find(Request $request) {
        $route = new Route();
        $req = [1, 4];
        $stopsAndSeq = RouteStopSequence::get();
        $routesRaw = RouteStopSequence::select('route_id')
            ->whereIn('stop_id', [1, 4])
            ->groupBy('route_id')
            ->havingRaw('COUNT(stop_id) > ?', [1])
            ->get()
            ->toArray();
        $routes = array_map(fn($item) => $item['route_id'], $routesRaw);
        $firstAndLastStops = RouteStopSequence::selectRaw('route_id, MIN(sequence) AS start, MAX(sequence) AS finish')
            ->whereIn('route_id', $routes)
            ->groupBy('route_id')
            ->get()
            ->toArray();
        $buses = Bus::whereIn('route_id', $routes)->get()->toArray();
        $schelule = Route::whereIn('id', $routes)->get()->toArray();
        $stops = Stop::get()->toArray();
        dump($firstAndLastStops);
        $data = [$stopsAndSeq, $schelule, $buses, $stops, $req];
        $buses = $route->findBuses($data);
        return view('welcome', compact('buses'));
    }
}
