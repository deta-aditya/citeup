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

    <title>{{ config('app.name', 'CITE UP') }} &middot; Seleksi Online</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('images/web/favicon.png') }}" rel="shortcut icon" type="image/png">
</head>
<body>
    <div id="app-elimination">
        <div class="text-center cloak-content" :style="{ height: '100vh', paddingTop: '300px' }" v-if="isLoading">
            <i class="fa fa-spinner fa-pulse fa-3x"></i>
        </div>
        <template v-else>
            <message-box ref="rulesBox" name="rules-box" size="lg" :footerless="true">
                <template slot="title">Peraturan Seleksi Online</template>
                <div class="super-list">
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>1</span>
                        </div>
                        <div class="super-list-content">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.</p>
                            <p>Nunc viverra imperdiet enim. Fusce est. Vivamus a tellus.</p>
                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede. Mauris et orci.</p>
                            <p>Aenean nec lorem. In porttitor. Donec laoreet nonummy augue.</p>
                            <p>Suspendisse dui purus, scelerisque at, vulputate vitae, pretium mattis, nunc. Mauris eget neque at sem venenatis eleifend. Ut nonummy.</p>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>2</span>
                        </div>
                        <div class="super-list-content">
                            Godspeed.
                        </div>
                    </div>
                </div>
            </message-box>
            <message-box ref="guideBox" name="guide-box" size="lg" :footerless="true">
                <template slot="title">Panduan Seleksi Online</template>
                <div class="super-list">
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>1</span>
                        </div>
                        <div class="super-list-content">
                            <p>Aenean nec lorem. In porttitor. Donec laoreet nonummy augue.</p>
                            <p>Suspendisse dui purus, scelerisque at, vulputate vitae, pretium mattis, nunc. Mauris eget neque at sem venenatis eleifend. Ut nonummy.</p>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>2</span>
                        </div>
                        <div class="super-list-content">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.</p>
                            <p>Nunc viverra imperdiet enim. Fusce est. Vivamus a tellus.</p>
                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede. Mauris et orci.</p>
                            <div class="text-center"><img src="{{ asset('images/default.jpg') }}" class="img-rounded"></div>
                        </div>
                    </div>
                </div>
            </message-box>
            <sticky-chat></sticky-chat>
            <div class="grad-top"></div>
            <div id="app-header">
                <div class="container text-center">
                    <img class="app-logo" src="{{ asset('images/web/logo_simple_sm.png') }}">
                    <div id="subtitle">Online Elimination</div>
                    <ul id="app-nav" class="list-inline text-center">
                        {{-- @if ($stage->id === $elimination->id) --}}
                        <template v-if="! countdown">
                            <li><a href="#" @click.prevent="$refs.rulesBox.open">Peraturan</a></li>
                            <li><a href="#" @click.prevent="$refs.guideBox.open">Panduan</a></li>
                        </template>
                        <li><a href="{{ route('dashboard') }}">Keluar</a></li>
                    </ul>
                </div>
            </div>
            <div class="countdown-begin" v-if="countdown">
                <div class="countdown-title">Seleksi akan dimulai dalam</div>
                <countdown done="{{ $elimination->started_at }}" @done="reload"></countdown>
            </div>
            {{-- <timebar v-if="working" finish="{{ $elimination->finished_at }}"></timebar> --}}
            <timebar v-if="working" finish="2017-10-01 00:48:40" @done="finish"></timebar>
            <div id="app-main-view">
                <div class="container">
                    <router-view></router-view>
                </div>
            </div>
            <div class="app-help">
                <div class="container">Ada yang kurang jelas? Bingung? <a href="#">Tanyakan panitia</a>.</div>
            </div>
            <div class="app-footer">
                <div class="container">
                    <div>&copy; {{ date('Y') }} Ilmu Komputer, Fakultas Sains &amp; Komputer, Universitas Pertamina.</div>
                    <p class="help-block"><small>{{ config('app.version') }}. This section is developed and maintained by <a href="https://github.com/purplebubblegum" style="color:#991e9b">purplebubblegum</a>.</small></p>
                </div>
            </div>
        </template>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/elim.js') }}"></script>
</body>
</html>
