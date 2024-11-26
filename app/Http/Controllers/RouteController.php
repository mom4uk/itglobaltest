<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function find() {
        $route = new Route();
        $stub = ['from' => 'Пушкина', 'to' => 'Ленина'];
        $buses = $route->findBuses($stub);
        return view('index', compact('buses')); // в index пойдет вывод автобусов
    }
}
