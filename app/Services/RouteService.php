<?php

namespace App\Services;

use App\Models\RouteStopSequence;

class RouteService
{
    public function getNormalizedRouteData($routeIds): array
    {
        return array_map(function ($id) {
            $routeData = RouteStopSequence::
                select(
                    'route_stop_sequences.route_id',
                    'route_stop_sequences.stop_id',
                    'route_stop_sequences.sequence_forward',
                    'route_stop_sequences.sequence_backward',
                    'stops.name',
                    'buses.number as bus_number',
                    'routes.initial_stop_departure_time',
                    'routes.final_stop_departure_time',
                    'routes.half_route_time'
                )
                ->join('stops', 'route_stop_sequences.stop_id', '=', 'stops.id')
                ->join('routes', 'route_stop_sequences.route_id', '=', 'routes.id')
                ->join('buses', 'route_stop_sequences.route_id', '=', 'buses.route_id')
                ->where('route_stop_sequences.route_id', $id)
                ->get()
                ->toArray();

            return ['id' => $id, 'data' => $routeData];
        }, $routeIds);
    }

    public function getSortedSequenceData($routeId): array
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

        $sorted = collect($stopSequencesData)->sortBy('id')->values()->toArray();
        return ['routeId' => $routeId, 'data' => $sorted];
    }

    public function updateRouteStops($routeId, $stopIds, $isDirectionForward): void
    {
        $splitedStops = explode(',', $stopIds);

        $sequence = $isDirectionForward ? 'sequence_forward' : 'sequence_backward';

        $existingStops = RouteStopSequence::where('route_id', $routeId)
            ->pluck('stop_id')
            ->toArray();

        $stopsToRemove = array_diff($existingStops, $splitedStops);

        $this->removeStops($routeId, $stopsToRemove, $sequence);

        foreach ($splitedStops as $index => $stopId) {
            if (in_array($stopId, $existingStops, true)) {
                $this->updateStop($routeId, $stopId, $sequence, $index);
            } else {
                $this->addStop($routeId, $stopId, $sequence, $index);
            }
        }
    }

    private function removeStops($routeId, $stopsToRemove, $sequence): void
    {
        if (!empty($stopsToRemove)) {
            RouteStopSequence::where('route_id', $routeId)
                ->whereIn('stop_id', $stopsToRemove)
                ->update([$sequence => null]);

            RouteStopSequence::whereNull('sequence_forward')
                ->whereNull('sequence_backward')
                ->delete();
        }
    }

    private function updateStop($routeId, $stopId, $sequence, $index): void
    {
        RouteStopSequence::where('route_id', $routeId)
            ->where('stop_id', $stopId)
            ->update([$sequence => $index]);
    }

    private function addStop($routeId, $stopId, $sequence, $index): void
    {
        RouteStopSequence::create([
            'route_id' => $routeId,
            'stop_id' => $stopId,
            $sequence => $index,
        ]);
    }
}
