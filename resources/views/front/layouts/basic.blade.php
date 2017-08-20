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

    <title>
        {{ config('app.name', 'CITE UP') }} 
        @if (! request()->is('/')) 
            &middot; @yield('title')
        @else
            &middot; Computer and IT Event Universitas Pertamina
        @endif
    </title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('images/web/favicon.png') }}" rel="shortcut icon" type="image/png">

    @if (false)
        <meta name="recaptcha-sitekey" content="{{ config('recaptcha.sitekey') }}">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
</head>
<body>
    <div id="app-front">
        @include('front.partials.nav')

        <div class="front-content">
            @yield('content')
        </div>

        @include('front.partials.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/front.js') }}"></script>
    @yield('scripts')
</body>
</html>
