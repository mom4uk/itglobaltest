<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Stop;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function find(Request $request) {
        $stub = [$request->from, $request->to];
        $stops = Stop::select('*')->whereIn('id', [1, 2])->get();
        $routesSchedule = Route::get();
        $data = []; // here query in db for route data
        // $buses = $route->findBuses($data);
        return view('welcome', compact('busNumbers')); // в index пойдет вывод автобусов
    }
}
