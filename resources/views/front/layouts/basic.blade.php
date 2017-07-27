<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- The App Root Path -->
    <meta name="app-path" content="{{ url('/') }}">

    <title>{{ config('app.name', 'CiteUP') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app-front">
        @include('front.partials.nav')

        @yield('content')

        @include('front.partials.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/front.js') }}"></script>
</body>
</html>
