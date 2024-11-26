@extends('layouts.app')

@section('content')
    {{ html()->modelForm('GET', route('api.find-bus'))->open() }}
    {{  html()->label('Откуда', 'from') }}
    {{  html()->input('text', 'from') }}
    {{  html()->label('Куда', 'to') }}
    {{  html()->input('text', 'to') }}
    {{ html()->submit('Найти')->class('btn btn-primary') }}
    {{ html()->closeModelForm() }}
@endsection