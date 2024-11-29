@extends('layouts.app')


@section('content')
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

@endsection

@section('update')
    <br>
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
@endsection