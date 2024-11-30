<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Маршруты автобусов</title>
    </head>
    <body>
        <h1>Маршруты автобусов</h1>
        <div class="container mt-4">
        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{  html()->form('GET', route('api.find-bus'))->open() }}
    {{  html()->label('Откуда', 'from') }}
    {{  html()->input('text', 'from') }}
    {{  html()->label('Куда', 'to') }}
    {{  html()->input('text', 'to') }}
    {{ html()->submit('Найти')->class('btn btn-primary') }}
    {{ html()->closeModelForm() }}
        </div>
        <div class="container mt-4">
        <br>
    <br>
    {{  html()->form('PATCH', route('api.update-bus'))->open() }}
    <br>
    <br>
    <br>
    <h3>Введите последовательность id остановок и id маршрута</h3><br>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{ html()->label('id маршрута', 'route_id') }}<br>
    {{ html()->input('text', 'route_id') }}<br>

    {{ html()->label('id остановок', 'stop_ids') }}<br>
    {{ html()->input('text', 'stop_ids') }}<br>
    {{ html()->submit('Изменить') }}
    {{ html()->closeModelForm() }}
        </div>
    </body>
</html>