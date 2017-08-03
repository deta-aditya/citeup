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
        {{ config('app.name', 'CiteUP') }} 
        @if (! request()->is('/')) 
            &middot; Error &middot; @yield('code')
        @endif
    </title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('images/web/favicon.png') }}" rel="shortcut icon" type="image/png">
</head>
<body>
    <div id="app-front">

        <div id="error-page" class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-4">
                    <div class="logo-placeholder">
                        <img src="{{ asset('images/web/logo_simple_sm.png') }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="error-code text-right">@yield('code')</div>
                </div>
                <div class="col-sm-8">
                    <h1 class="pun">Ehh Ada Apa Ini ??</h1>
                    <div class="error-message">@yield('message')</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/front.js') }}"></script>
</body>
</html>
