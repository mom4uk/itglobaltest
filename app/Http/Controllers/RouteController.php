<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteStopSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\RouteService;

class RouteController extends Controller
{
    protected $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    public function index()
    {
        $routesRaw = Route::select('id')
            ->get()
            ->toArray();
        $routesNums = array_map(fn($item) => $item['id'], $routesRaw);
        $routes = array_map([$this->routeService, 'getSortedSequenceData'], $routesNums);
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

        $normalizedData = $this->routeService->getNormalizedRouteData($routes);
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
            return redirect('/')->withErrors($validator, 'updateErrors')->withInput();
        }

        $stopIds = explode(',', $request->stop_ids);
        $this->routeService->updateRouteStops($request->route_id, $stopIds, $request->is_direction_forward);
        return redirect('/')->with('success', 'Успешно обновлено');
    }
}