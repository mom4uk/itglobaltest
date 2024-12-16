@extends('layouts.app')

@section('output')
    <div class="routes-container">
        @foreach ($routes as $route)
            <div class="route">
                <h3>Маршрут №{{ $route['routeId'] }}</h3>
                <table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Название остановки</th>
                            <th>Последовательность (прямо)</th>
                            <th>Последовательность (обратно)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($route['data'] as $stop)
                            <tr>
                                <td>{{ $stop['name'] }}</td>
                                <td>{{ $stop['sequence_forward'] }}</td>
                                <td>{{ $stop['sequence_backward'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br>
        @endforeach
    </div>
@endsection