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
                    'routes.minutes_between_stops'
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
        $sequence = $isDirectionForward ? 'sequence_forward' : 'sequence_backward';
        foreach ($stopIds as $index => $stopId) {
            RouteStopSequence::where('route_id', $routeId)
                ->where('stop_id', $stopId)
                ->update([$sequence => $index]);
        }
    }
}
