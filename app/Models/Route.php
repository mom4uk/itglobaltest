<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Route extends Model
{
    public function findBuses($data, $req): string
    {
        $routeIds = collect($data)->pluck('id')->all();
        $routesInfo = array_map(function ($id) use ($data, $req) {
            $coll = collect($data)
                ->filter(fn($item) => $item['id'] === $id)
                ->pluck('data')
                ->flatten(1);

            $busNum = $coll->first()['bus_number'];

            $directionForward = $this->isRouteForward($coll, $req);

            $startTime = $directionForward ?
                $coll->value('initial_stop_departure_time') :
                $coll->value('final_stop_departure_time');

            $lastStopName = $this->getLastStop($coll, $directionForward); // will change

            $arrivales = $this->getArrivales($coll, $startTime, $directionForward);

            $nextArrivales = $this->getNextArrivales($arrivales);

            return $this->getRouteInfo($busNum, $nextArrivales, $lastStopName);
        }, $routeIds);

        $result = $this->getFullInfo($routesInfo, $req, $data);
        
        return json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    private function getFullInfo($routesInfo, $reqId, $data)
    {
        [$from, $to] = $reqId;

        $fromNameStop = collect($data)
            ->flatMap(fn($item) => $item['data'])
            ->firstWhere('stop_id', $from)['name'];

        $toNameStop = collect($data)
            ->flatMap(fn($item) => $item['data'])
            ->firstWhere('stop_id', $to)['name'];

        return ['from' => $fromNameStop, 'to' => $toNameStop, 'buses' => $routesInfo];
    }

    private function getLastStop($coll, $directionForward)
    {
        $sequence = $directionForward ? 'sequence_forward' : 'sequence_backward';
        $sorted = $coll->sortBy($sequence);
        return $sorted->last()['name'];
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
        $currentTime = Carbon::now('Europe/Moscow')->format('H:i');
        $currentTimestamp = strtotime($currentTime);

        $closestTime = collect($arrivales)
            ->sortBy(fn($time) => abs(strtotime($time) - $currentTimestamp))
            ->first();
        $closestTimeIndex = array_search($closestTime, $arrivales);
        $result = strtotime($closestTime) < $currentTimestamp
            ? ['Next stops will be tomorrow']
            : array_slice($arrivales, $closestTimeIndex, 3);
        return $result;
    }

    private function getArrivales($coll, $initialTime, $directionForward)
    {
        $startTime = Carbon::parse($initialTime)->format('H:i');
        $result = [$startTime];
        $stops = $directionForward ? $coll->all() : $coll->reverse()->all();
        $minutesBetweenStops = $coll->value('minutes_between_stops');

        for ($i = 1; $i <= count($stops); $i += 1) {
            $date = $result[$i - 1];
            $newDate = Carbon::parse($date)
                ->addMinutes($minutesBetweenStops)
                ->format('H:i');
            $result[] = $newDate;
        }
        return $result;
    }

    private function isRouteForward($coll, $req)
    {
        [$from, $to] = $req;
        $fromSeq = $coll->firstWhere('stop_id', $from)['sequence_forward'];
        $toSeq = $coll->firstWhere('stop_id', $to)['sequence_forward'];
        return $fromSeq - $toSeq < 0;
    }
}
