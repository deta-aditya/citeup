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

    @if ($user->isEntrant()) 
        <!-- The Elim Path -->
        <meta name="elim-path" content="{{ $user->entry->activity_id === 1 ? route('elimination') : route('submission') }}/">
    @endif

    <title>{{ config('app.name', 'CiteUP') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('images/web/favicon.png') }}" rel="shortcut icon" type="image/png">
</head>
<body>
    <div id="app-dashboard">
        
        <div class="text-center cloak-content" style="height:100vh;padding-top:200px" v-if="isLoading">
            <img src="{{ asset('images/web/logo_simple_sm.png') }}" style="height:60px;padding-bottom:30px">
            <div><i class="fa fa-spinner fa-pulse fa-3x"></i></div>
        </div>
        <template v-else>
            <app-topbar v-if="hasNav">
                <template slot="brand">{{ config('app.name', 'CiteUP') }}</template>
            </app-topbar>

            <div id="app-main">
                <app-sidebar v-if="hasNav"></app-sidebar>
                <div id="app-page">
                    <spacer :vertical="topbarHeight"></spacer>
                    <div class="app-view" ref="appView" @scroll="detectMaxScrollHeight($event.target)">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </template>
        
        <app-info ref="info" :user="{{ $user->toJson() }}"></app-info>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
