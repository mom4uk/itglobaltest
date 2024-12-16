@extends('layouts.app')

@section('find')
    <div class="col-md-6">
        <h3 class="text-primary mb-4">Введите ID начальной и конечной остановок</h3>

        <form method="GET" action="{{ route('api.find-bus') }}" class="card p-4 border-0 shadow-lg">
            @csrf

            @if ($errors->findErrors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->findErrors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="from" class="form-label">Откуда:</label>
                <input type="text" id="from" name="from" class="form-control" value="{{ old('from') }}" placeholder="Введите ID остановки">
            </div>

            <div class="mb-3">
                <label for="to" class="form-label">Куда:</label>
                <input type="text" id="to" name="to" class="form-control" value="{{ old('to') }}" placeholder="Введите ID остановки">
            </div>

            <button type="submit" class="btn btn-primary w-100">Найти</button>
        </form>

        @if (session('buses'))
            <div class="mt-4">
                <h4 class="text-success">Результаты поиска:</h4>
                <pre class="bg-light p-3 border rounded shadow-sm">
                    {{ json_encode(session('buses'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                </pre>
            </div>
        @endif
    </div>
@endsection

@section('update')
    <div class="col-md-6">
        <h3 class="text-primary mb-4">Введите последовательность ID остановок и ID маршрута</h3>

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('api.update-bus') }}" class="card p-4 border-0 shadow-lg">
            @csrf
            @method('PATCH')

            @if ($errors->updateErrors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->updateErrors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="route_id" class="form-label">ID маршрута:</label>
                <input type="text" id="route_id" name="route_id" class="form-control" value="{{ old('route_id') }}" placeholder="Введите ID маршрута">
            </div>

            <div class="mb-3">
                <label for="stop_ids" class="form-label">ID остановок:</label>
                <input type="text" id="stop_ids" name="stop_ids" class="form-control" value="{{ old('stop_ids') }}" placeholder="Введите ID остановок через запятую">
            </div>

            <div class="mb-3">
                <label for="is_direction_forward" class="form-label">Направление:</label>
                <select id="is_direction_forward" name="is_direction_forward" class="form-select">
                    <option value="1" {{ old('is_direction_forward') === "1" ? 'selected' : '' }}>Прямо</option>
                    <option value="0" {{ old('is_direction_forward') === "0" ? 'selected' : '' }}>Обратно</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100">Изменить</button>
        </form>
    </div>
@endsection

@section('output')
    <div class="container mt-5">
        <h3 class="text-primary mb-4">Список маршрутов</h3>
        <div class="row g-4">
            @foreach ($routes as $route)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-lg h-100">
                        <div class="card-body">
                            <h4 class="card-title text-secondary">Маршрут №{{ $route['routeId'] }}</h4>
                            <table class="table table-sm table-striped mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID остановки</th>
                                        <th>Название остановки</th>
                                        <th>Прямо</th>
                                        <th>Обратно</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($route['data'] as $stop)
                                        <tr>
                                            <td>{{ $stop['id'] }}</td>
                                            <td>{{ $stop['name'] }}</td>
                                            <td>{{ $stop['sequence_forward'] }}</td>
                                            <td>{{ $stop['sequence_backward'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
