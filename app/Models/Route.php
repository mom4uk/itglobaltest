<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Route extends Model
{
    public function findBuses($data, $req): array
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

            $lastStopName = $this->getLastStop($coll, $directionForward);

            $arrivales = $this->getArrivales($coll, $startTime, $directionForward);

            $nextArrivales = $this->getNextArrivales($arrivales);

            return $this->getRouteInfo($busNum, $nextArrivales, $lastStopName);
        }, $routeIds);

        $result = $this->getFullInfo($routesInfo, $req, $data);
        return $result;
    }

    private function getFullInfo($routesInfo, $reqId, $data): array
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

    private function getLastStop($coll, $directionForward): string
    {
        $sequence = $directionForward ? 'sequence_forward' : 'sequence_backward';
        $sorted = $coll->sortBy($sequence);
        return $sorted->last()['name'];
    }

    private function getRouteInfo($busNumber, $arrivales, $lastStop): array
    {
        return [
            'route' => "Автобус №{$busNumber} в сторону ост. {$lastStop}",
            'next_arrivals' => $arrivales
        ];
    }

    private function getNextArrivales($arrivales): array
    {
        $currentTime = Carbon::now('Europe/Moscow')->format('H:i');
        $currentTimestamp = strtotime($currentTime);

        $closestTime = collect($arrivales)
            ->filter(fn($time) => strtotime($time) >= $currentTimestamp)
            ->sortBy(fn($time) => abs(strtotime($time) - $currentTimestamp)) // ???
            ->first();
        $closestTimeIndex = array_search($closestTime, $arrivales);

        $result = $closestTime
            ? array_slice($arrivales, $closestTimeIndex, 3)
            : ['The next arrival will be tomorrow.'];
        return $result;
    }

    private function getArrivales($coll, $initialTime): array
    {
        $numberOfStops = $coll->count();
        $routeTime = $coll->first()['half_route_time'];

        $start = Carbon::parse($initialTime);
        $end = Carbon::parse($initialTime)->addHours($routeTime);
        $interval = $start->diffInSeconds($end) / ($numberOfStops - 1);

        $result = [];

        for ($i = 0; $i < $numberOfStops; $i += 1) {
            $result[] = $start->copy()->addSeconds($interval * $i)->format('H:i');
        }
        return $result;
    }

    private function isRouteForward($coll, $req): bool
    {
        [$from, $to] = $req;
        $fromSeq = $coll->firstWhere('stop_id', $from)['sequence_forward'];
        $toSeq = $coll->firstWhere('stop_id', $to)['sequence_forward'];
        return $fromSeq - $toSeq < 0;
    }
}
