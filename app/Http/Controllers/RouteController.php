<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteStopSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    public function index()
    {
        $routesRaw = Route::select('id')
            ->get()
            ->toArray();
        $routesNums = array_map(fn($item) => $item['id'], $routesRaw);
        $routes = array_map([$this, 'getSequenceData'], $routesNums);
        return view('welcome', compact('routes'));
    }

    public function find(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required|integer|different:to',
            'to' => 'required|integer|different:from',
        ]);

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator, 'findErrors')->withInput();
        }

        $req = [$request->from, $request->to];

        $routesRaw = RouteStopSequence::select('route_id')
            ->whereIn('stop_id', $req)
            ->groupBy('route_id')
            ->havingRaw('COUNT(stop_id) > ?', [1])
            ->get()
            ->toArray();
        $routes = array_map(fn($item) => $item['route_id'], $routesRaw);

        $normalizedData = array_map([$this, 'normalizeRouteData'], $routes);
        $route = new Route();
        $buses = $route->findBuses($normalizedData, $req);
        return redirect('/')->with(['buses' => $buses]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_id' => 'required|integer',
            'stop_ids' => 'required|string',
            'is_direction_forward' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'updateErrors')->withInput();
        }

        $stopIds = explode(',', $request->stop_ids);
        $routeId = $request->route_id;
        $sequence = $request->is_direction_forward ? 'sequence_forward' : 'sequence_backward';
        foreach ($stopIds as $stopId) {
            $index = array_search($stopId, $stopIds);
            RouteStopSequence::where('route_id', $routeId)
            ->where('stop_id', $stopId)
            ->update([$sequence => $index]);
        }
        return redirect('/');
    }

    private function normalizeRouteData($id)
    {
        $routeData = RouteStopSequence::
            select(
                'route_stop_sequences.route_id',
                'route_stop_sequences.stop_id',
                'route_stop_sequences.sequence_forward',
                'route_stop_sequences.sequence_backward',
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
            'stops.id',
            'route_stop_sequences.sequence_forward',
            'route_stop_sequences.sequence_backward'
        )
            ->join('stops', 'route_stop_sequences.stop_id', '=', 'stops.id')
            ->where('route_id', $routeId)
            ->get()
            ->toArray();
        $sorted = collect($stopSequencesData)->sortBy('sequence')->values();
        return ['routeId' => $routeId, 'data' => $sorted];
    }
}
