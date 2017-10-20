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
        <div class="text-center cloak-content" style="height:100vh;padding-top:300px" v-if="isLoading">
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
                            Babak penyisihan dilakukan secara online pada 21 Oktober 2017 pukul 09:00 WIB hingga 22 Oktober 2017 pukul 09:00 WIB.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>2</span>
                        </div>
                        <div class="super-list-content">
                            Peserta diharuskan untuk mengakses halaman ini beberapa menit sebelum seleksi dimulai.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>3</span>
                        </div>
                        <div class="super-list-content">
                            Peserta diharuskan untuk terkoneksi pada jaringan internet cepat agar tidak terputus pada rentang waktu tersebut. Apabila koneksi peserta terputus, peserta dapat mengakses kembali halaman ini dan melanjutkan tahap penyisihan tanpa diberikan tambahan waktu.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>4</span>
                        </div>
                        <div class="super-list-content">
                            Panitia memiliki hak untuk mendiskualifikasi peserta yang terindikasi melakukan pelanggaran.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>5</span>
                        </div>
                        <div class="super-list-content">
                            Peserta diharuskan untuk membuat sebuah poster dengan tema yang akan diumumkan saat waktu seleksi dimulai.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>6</span>
                        </div>
                        <div class="super-list-content">
                            Peserta diharuskan untuk menggunakan palette warna yang disediakan oleh panitia dalam pembuatan karyanya. Palette akan diumumkan bersama dengan tema poster.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>7</span>
                        </div>
                        <div class="super-list-content">
                            Peserta diharuskan untuk menulis deskripsi singkat mengenai karyanya pada tempat yang disediakan saat waktu seleksi.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>8</span>
                        </div>
                        <div class="super-list-content">
                            Segala jenis aktifitas peserta seperti mengirimkan file poster terekam oleh panitia.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>9</span>
                        </div>
                        <div class="super-list-content">
                            Peserta yang bertanya kepada panitia diharuskan untuk menuliskan pertanyaannya dengan singkat dan jelas. 
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
                            Klik pada tombol "Browse" pada bagian Karya Poster untuk mengunggah karya Anda.
                            <div><img src="{{ asset('images/web/guide0.png') }}" class="img-rounded"></div>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>2</span>
                        </div>
                        <div class="super-list-content">
                            Kumpulkan karyamu sebelum waktu yang tersedia habis!
                            <div><img src="{{ asset('images/web/guide3.png') }}" class="img-rounded"></div>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>3</span>
                        </div>
                        <div class="super-list-content">
                            Sudah yakin dengan karya Anda? Klik tombol selesai, lalu konfirmasi dengan mengklik tombol selesai pada jendela.
                            <div><img src="{{ asset('images/web/guide4.png') }}" class="img-rounded"></div>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>4</span>
                        </div>
                        <div class="super-list-content">
                            Kebingungan? Tanyakan kejelasan kepada panitia dengan mengklik tombol "Tanya Panitia", lalu ketik pertanyaan Anda.
                            <div><img src="{{ asset('images/web/guide5.png') }}" class="img-rounded"></div>
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
            <timebar v-if="working" :start="timebarStart" :finish="timebarFinish" @done="autoPersist"></timebar>
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
    <script src="{{ asset('js/submit.js') }}"></script>
</body>
</html>
