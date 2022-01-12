<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Тестовое задание</title>
        <link href="{{ asset('css/app.css') }}?v={{rand()}}" rel="stylesheet">

        <link rel="shortcut icon" href="{{env('APP_PATH')}}favicon.ico" type="image/x-icon">
    </head>

    <body>
        <div id="app"></div>
    </body>

    <script src="{{ asset('js/app.js') }}?v={{ time() }}"></script>
</html>
