<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Route extends Model
{
    private $minutesBetweenStops = 40; // this is need to transfer to db, table routes

    public function findBuses($data): string {
        [$numOfStops, $schedule, $buses, $stops, $req] = $data;
        $routeId = [1,2];
        $routesInfo = array_map(function ($id) use ($numOfStops, $schedule, $buses, $stops, $req) {
            $bus = array_values(array_filter($buses, fn($item) => $item['route_id'] === $id))[0]; // think how to fix indexes / not use indexes here
            $busNum = $bus['number'];

            $isRouteForward = $this->isRouteForward($stops, $req);

            $route = array_find($schedule, fn($item) => $item['id'] === $id);
            $startTime = $isRouteForward ? $route['initial_stop_departure_time'] : $route['final_stop_departure_time'];
            // you should use collect when you will rewrite it
            $lastStopName = $this->getLastStop($stops, $isRouteForward, $id);

            $numOfStopsForRoute = array_find($numOfStops, fn($item) => $item['route_id'] === $id);

            $arrivales = $this->getArrivales($numOfStopsForRoute, $startTime, $isRouteForward);
            $nextArrivales = $this->getNextArrivales($arrivales);

            return $this->getRouteInfo($busNum, $nextArrivales, $lastStopName);
        }, $routeId);
        $result = $this->getFullInfo($routesInfo, $req, $stops);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    private function getFullInfo($routesInfo, $reqId, $stops)
    {
        [$from, $to] = $reqId;

        $fromNameStop = collect($stops)
            ->first(fn($item) => $item['stop_id'] === $from)['name'];

        $toNameStop = collect($stops)
        ->first(fn($item) => $item['stop_id'] === $to)['name'];

        return ['from' => $fromNameStop, 'to' => $toNameStop, 'buses' => $routesInfo];
    }

    private function getLastStop($stops, $direction, $id)
    {
        $lastStopName = [];
        if ($direction) {
            $lastStopName = collect($stops) // you should use collect when you will rewrite it
                ->filter(fn($item) => $item['route_id'] === $id)
                ->sortBy('sequence')
                ->last()['name'];
        } else {
            $lastStopName = collect($stops) // you should use collect when you will rewrite it
            ->filter(fn($item) => $item['route_id'] === $id)
            ->sortBy('sequence')
            ->first()['name'];
        }
        return $lastStopName;
    }

    private function getRouteInfo($busNumber, $arrivales, $lastStop)
    {
        return [
            'route' => "Автобус №{$busNumber} в сторону ост. {$lastStop}",
            'next_arrivals' => $arrivales
        ];
    }

    private function getNextArrivales($arrivales)
    {
        $currentTime = date('11:30'); // stub
        $currentTimestamp = strtotime($currentTime);

        $closestTime = collect($arrivales)
        ->sortBy(fn($time) => abs(strtotime($time) - $currentTimestamp))
        ->first();
        $index = array_search($closestTime, $arrivales);
        return array_slice($arrivales, $index, 3);
    }

    private function getArrivales($stops, $initialTime, $direction)
    {
        $date = new \DateTimeImmutable($initialTime);
        $startTime = $date->format('H:i');
        $result = [$startTime];
        if ($direction) {
            for ($i = 1; $i <= $stops['number_stops']; $i += 1) {
                $date = new \DateTimeImmutable($result[$i - 1]);
                $result[] = $date->modify("+{$this->minutesBetweenStops} minutes")->format('H:i');
            }
        } else {
            for ($i = $stops['number_stops']; $i >= 0; $i -= 1) {
                $date = new \DateTimeImmutable($result[count($result) - 1]);
                $result[] = $date->modify("+{$this->minutesBetweenStops} minutes")->format('H:i');
            }
        }
        return $result;
    }
    
    private function isRouteForward($stops, $req) { // мб reduce сделать нормальные данные и обрабобтать их нормально, а не этой порнухой
        [$from, $to] = $req;
        $reqStops = array_filter($stops, fn($item) => in_array($item['stop_id'], [$from, $to]));
        $fromSeq = array_find($reqStops, fn($item) => $item['stop_id'] === $from)['sequence'];
        $toSeq = array_find($reqStops, fn($item) => $item['stop_id'] === $to)['sequence'];
        return $fromSeq - $toSeq < 0;
    }
}
