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

    <!-- Favicon -->
    <link href="{{ asset('storage/images/web/favicon.png') }}" rel="shortcut icon" type="image/png">
</head>
<body>
    <div id="app-dashboard">

        <app-info ref="info" :user="{{ $user->toJson() }}"></app-info>

        <app-topbar v-if="hasNav">
            <template slot="brand">{{ config('app.name', 'CiteUP') }}</template>
        </app-topbar>

        <div id="app-main">
            <app-sidebar v-if="hasNav"></app-sidebar>
            <div id="app-page">
                <spacer :vertical="topbarHeight"></spacer>
                <router-view class="app-view"></router-view>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
