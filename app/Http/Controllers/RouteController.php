<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteStopSequence;
use App\Services\RouteService;
use App\Http\Requests\FindRequest;
use App\Http\Requests\UpdateRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RouteController extends Controller
{
    protected $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    public function index(): View
    {
        $routesRaw = Route::select('id')
            ->get()
            ->toArray();
        $routesNums = array_map(fn($item) => $item['id'], $routesRaw);
        $routes = array_map([$this->routeService, 'getSortedSequenceData'], $routesNums);
        return view('welcome', compact('routes', 'routesNums'));
    }

    public function find(FindRequest $request): RedirectResponse
    {
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

    public function update(UpdateRequest $request): RedirectResponse
    {
        $stopIds = explode(',', $request->stop_ids);
        $this->routeService->updateRouteStops($request->route_id, $stopIds, $request->is_direction_forward);
        return redirect('/')->with('success', 'Успешно обновлено');
    }
}