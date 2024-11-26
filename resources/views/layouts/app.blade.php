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
            @yield('content')
        </div>
    </body>
</html>