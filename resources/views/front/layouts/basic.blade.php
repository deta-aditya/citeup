<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CiteUP') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>.cloak { position:absolute;width:100%;height:100vh;color:#fff;z-index:999; }</style>
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
