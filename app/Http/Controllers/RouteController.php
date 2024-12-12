<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteStopSequence;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function welcome()
    {
        $routesRaw = Route::select('id')
            ->get()
            ->toArray();
        $routes = array_map(fn($item) => $item['id'], $routesRaw);
        $sequenceData = array_map([$this, 'getSequenceData'], $routes);
        return json_encode($sequenceData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function find(Request $request)
    {
        $request->validate([
            'from' => 'required|integer|different:to',
            'to' => 'required|integer|different:from'
        ]);

        $route = new Route();
        $req = [$request->from, $request->to];

        $routesRaw = RouteStopSequence::select('route_id')
            ->whereIn('stop_id', $req)
            ->groupBy('route_id')
            ->havingRaw('COUNT(stop_id) > ?', [1])
            ->get()
            ->toArray();
        $routes = array_map(fn($item) => $item['route_id'], $routesRaw);

        $normalizedData = array_map([$this, 'normalizeRouteData'], $routes);
        $buses = $route->findBuses($normalizedData, $req);
        return $buses;
    }

    public function update(Request $request)
    {
        $request->validate([
            'route_id' => 'required|integer',
            'stop_ids' => 'required'
        ]);

        $stopIds = explode(',', $request->stop_ids);
        $routeId = $request->route_id;
        foreach ($stopIds as $stopId) {
            $index = array_search($stopId, $stopIds);
            RouteStopSequence::where('route_id', $routeId)
            ->where('stop_id', $stopId)
            ->update(['sequence' => $index]);
        }
        $updatedSequence = $this->getSequenceData($routeId);
        return $updatedSequence;
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
                'minutes_between_stops'
            )
            ->join('stops', 'route_stop_sequences.stop_id', '=', 'stops.id')
            ->join('routes', 'route_stop_sequences.route_id', '=', 'routes.id')
            ->join('buses', 'route_stop_sequences.route_id', '=', 'buses.route_id')
            ->where('route_stop_sequences.route_id', $id)
            ->get()
            ->toArray();

        return ['id' => $id, 'data' => $routeData];
    }

    private function getSequenceData($routeId)
    {
        $stopSequencesData = RouteStopSequence::select(
            'route_stop_sequences.route_id', 
            'stops.name', 
            'route_stop_sequences.sequence'
            )
            ->join('stops','route_stop_sequences.stop_id','=','stops.id')
            ->where('route_id', $routeId)
            ->get()
            ->toArray();
        $sorted = collect($stopSequencesData)->sortBy('sequence')->values();
        return ['routeId' => $routeId, 'data' => $sorted];
    }
}
