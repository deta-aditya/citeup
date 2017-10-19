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

    <!-- CHANNEL -->
    <meta name="channel" content="{{ $channel }}">

    <title>{{ config('app.name', 'CITE UP') }} &middot; Monitor</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('images/web/favicon.png') }}" rel="shortcut icon" type="image/png">
</head>
<body>
    <div id="app-elimination">
        <div class="text-center cloak-content" style="height:100vh;padding-top:300px" v-if="isLoading">
            <i class="fa fa-spinner fa-pulse fa-3x"></i>
        </div>
        <template v-else>
            <div class="grad-top"></div>
            <div id="app-header">
                <div class="container text-center">
                    <img class="app-logo" src="{{ asset('images/web/logo_simple_sm.png') }}">
                    <div id="subtitle">Elimination Monitor</div>
                    <ul id="app-nav" class="list-inline text-center">
                        <li><a href="{{ route('dashboard') }}">Keluar</a></li>
                    </ul>
                </div>
            </div>
            <timebar :start="timebarStart" :finish="timebarFinish"></timebar>
            <div id="app-main-view">
                @if ((int)$channel === 1)
                    @include('monitor.logika')
                @elseif ((int)$channel === 2)
                    @include('monitor.desain')
                @endif
            </div>
            <div class="app-footer">
                <div class="container-fluid">
                    <div>&copy; {{ date('Y') }} Ilmu Komputer, Fakultas Sains &amp; Komputer, Universitas Pertamina.</div>
                    <p class="help-block"><small>{{ config('app.version') }}. This section is developed and maintained by <a href="https://github.com/purplebubblegum" style="color:#991e9b">purplebubblegum</a>.</small></p>
                </div>
            </div>
        </template>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/monitor.js') }}"></script>
</body>
</html>
